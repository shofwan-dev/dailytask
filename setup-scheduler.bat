@echo off
REM Setup Windows Task Scheduler untuk Laravel DailyTask
REM Run as Administrator

echo ========================================
echo Setup Laravel Scheduler - DailyTask
echo ========================================
echo.

REM Cek apakah running as Administrator
net session >nul 2>&1
if %errorLevel% neq 0 (
    echo [ERROR] Script ini harus dijalankan sebagai Administrator!
    echo.
    echo Cara menjalankan:
    echo 1. Klik kanan pada file ini
    echo 2. Pilih "Run as administrator"
    echo.
    pause
    exit /b 1
)

REM Set variables
set TASK_NAME=Laravel DailyTask Scheduler
set PHP_PATH=C:\laragon\bin\php\php-8.2.12\php.exe
set PROJECT_PATH=C:\laragon\www\dailytask

REM Cek apakah PHP ada
if not exist "%PHP_PATH%" (
    echo [WARNING] PHP path tidak ditemukan: %PHP_PATH%
    echo Mencari PHP di Laragon...
    
    REM Cari PHP di Laragon
    for /f "delims=" %%i in ('dir /b /ad /o-n "C:\laragon\bin\php\php-*" 2^>nul') do (
        set PHP_PATH=C:\laragon\bin\php\%%i\php.exe
        goto :found_php
    )
    
    :found_php
    if exist "%PHP_PATH%" (
        echo [OK] PHP ditemukan: %PHP_PATH%
    ) else (
        echo [ERROR] PHP tidak ditemukan!
        echo Silakan edit file ini dan sesuaikan PHP_PATH
        pause
        exit /b 1
    )
)

echo PHP Path: %PHP_PATH%
echo Project Path: %PROJECT_PATH%
echo.

REM Hapus task lama jika ada
schtasks /query /tn "%TASK_NAME%" >nul 2>&1
if %errorLevel% equ 0 (
    echo [WARNING] Task sudah ada, menghapus task lama...
    schtasks /delete /tn "%TASK_NAME%" /f >nul 2>&1
)

REM Buat task baru
echo Membuat Task Scheduler...
schtasks /create /tn "%TASK_NAME%" /tr "\"%PHP_PATH%\" artisan schedule:run" /sc minute /mo 1 /st 00:00 /sd %date% /f /rl highest /ru "%USERNAME%" /it

if %errorLevel% equ 0 (
    echo.
    echo [SUCCESS] Task Scheduler berhasil dibuat!
    echo.
    echo [DETAIL TASK]
    echo    Nama: %TASK_NAME%
    echo    Interval: Setiap 1 menit
    echo    Command: %PHP_PATH% artisan schedule:run
    echo    Working Dir: %PROJECT_PATH%
    echo.
    echo [VERIFIKASI]
    schtasks /query /tn "%TASK_NAME%" /fo list /v | findstr /C:"Task To Run" /C:"Next Run Time" /C:"Status"
    echo.
    echo [SUCCESS] Setup selesai! Laravel Scheduler akan berjalan otomatis setiap menit.
    echo    WhatsApp reminder akan dikirim setiap 10 menit untuk task yang overdue.
    echo.
    echo [CATATAN]
    echo    - Task akan mulai berjalan dalam 1 menit
    echo    - Untuk melihat status: schtasks /query /tn "%TASK_NAME%"
    echo    - Untuk menghapus: schtasks /delete /tn "%TASK_NAME%" /f
    echo    - Untuk test manual: php artisan tasks:send-reminders
    echo.
) else (
    echo.
    echo [ERROR] Gagal membuat Task Scheduler!
    echo.
    echo [SOLUSI]
    echo    1. Pastikan menjalankan sebagai Administrator
    echo    2. Cek apakah path PHP sudah benar
    echo    3. Coba jalankan manual: php artisan schedule:run
    echo.
)

pause
