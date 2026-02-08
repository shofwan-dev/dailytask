# Setup Windows Task Scheduler untuk Laravel Scheduler
# Run as Administrator

$taskName = "Laravel DailyTask Scheduler"
$phpPath = "C:\laragon\bin\php\php-8.3.0-Win32-vs16-x64\php.exe"  # Sesuaikan dengan versi PHP Laragon Anda
$projectPath = "C:\laragon\www\dailytask"


# Cek apakah PHP path ada
if (-not (Test-Path $phpPath)) {
    Write-Host "[ERROR] PHP path tidak ditemukan: $phpPath" -ForegroundColor Red
    Write-Host "Mencari PHP di Laragon..." -ForegroundColor Yellow
    
    # Cari PHP di Laragon
    $phpSearchPath = "C:\laragon\bin\php"
    if (Test-Path $phpSearchPath) {
        $phpVersions = Get-ChildItem $phpSearchPath -Directory | Sort-Object Name -Descending
        if ($phpVersions.Count -gt 0) {
            $phpPath = Join-Path $phpVersions[0].FullName "php.exe"
            Write-Host "[OK] PHP ditemukan: $phpPath" -ForegroundColor Green
        }
    }
}

# Verifikasi PHP path
if (-not (Test-Path $phpPath)) {
    Write-Host "[ERROR] PHP tidak ditemukan! Silakan edit script ini dan sesuaikan path PHP." -ForegroundColor Red
    Write-Host "Contoh: C:\laragon\bin\php\php-8.2.0-Win32-vs16-x64\php.exe" -ForegroundColor Yellow
    exit 1
}

Write-Host "=== Setup Laravel Scheduler di Windows ===" -ForegroundColor Cyan
Write-Host "PHP Path: $phpPath" -ForegroundColor White
Write-Host "Project Path: $projectPath" -ForegroundColor White
Write-Host ""

# Hapus task lama jika ada
$existingTask = Get-ScheduledTask -TaskName $taskName -ErrorAction SilentlyContinue
if ($existingTask) {
    Write-Host "[WARNING] Task sudah ada, menghapus task lama..." -ForegroundColor Yellow
    Unregister-ScheduledTask -TaskName $taskName -Confirm:$false
}

# Buat action
$action = New-ScheduledTaskAction `
    -Execute $phpPath `
    -Argument "artisan schedule:run" `
    -WorkingDirectory $projectPath

# Buat trigger (setiap menit, indefinitely)
$trigger = New-ScheduledTaskTrigger -Once -At (Get-Date).Date -RepetitionInterval (New-TimeSpan -Minutes 1)

# Buat settings
$settings = New-ScheduledTaskSettingsSet `
    -AllowStartIfOnBatteries `
    -DontStopIfGoingOnBatteries `
    -StartWhenAvailable `
    -RunOnlyIfNetworkAvailable:$false `
    -DontStopOnIdleEnd `
    -ExecutionTimeLimit (New-TimeSpan -Minutes 5)

# Buat principal (run as current user)
$principal = New-ScheduledTaskPrincipal -UserId "$env:USERDOMAIN\$env:USERNAME" -LogonType S4U -RunLevel Highest

# Register task
try {
    Register-ScheduledTask `
        -TaskName $taskName `
        -Action $action `
        -Trigger $trigger `
        -Settings $settings `
        -Principal $principal `
        -Description "Menjalankan Laravel Scheduler untuk DailyTask setiap menit" `
        -ErrorAction Stop
    
    Write-Host ""
    Write-Host "[SUCCESS] Task Scheduler berhasil dibuat!" -ForegroundColor Green
    Write-Host ""
    Write-Host "[DETAIL TASK]" -ForegroundColor Cyan
    Write-Host "   Nama: $taskName" -ForegroundColor White
    Write-Host "   Interval: Setiap 1 menit" -ForegroundColor White
    Write-Host "   Command: $phpPath artisan schedule:run" -ForegroundColor White
    Write-Host "   Working Dir: $projectPath" -ForegroundColor White
    Write-Host ""
    Write-Host "[VERIFIKASI]" -ForegroundColor Cyan
    Get-ScheduledTask -TaskName $taskName | Format-List TaskName, State, LastRunTime, NextRunTime
    
    Write-Host ""
    Write-Host "[SUCCESS] Setup selesai! Laravel Scheduler akan berjalan otomatis setiap menit." -ForegroundColor Green
    Write-Host "   WhatsApp reminder akan dikirim setiap 10 menit untuk task yang overdue." -ForegroundColor Yellow
    Write-Host ""
    Write-Host "[CATATAN]" -ForegroundColor Cyan
    Write-Host "   - Task akan mulai berjalan dalam 1 menit" -ForegroundColor White
    Write-Host "   - Untuk melihat status: Get-ScheduledTask -TaskName '$taskName'" -ForegroundColor White
    Write-Host "   - Untuk menghapus: Unregister-ScheduledTask -TaskName '$taskName'" -ForegroundColor White
    Write-Host "   - Untuk test manual: php artisan tasks:send-reminders" -ForegroundColor White
    
}
catch {
    Write-Host ""
    Write-Host "[ERROR] Gagal membuat Task Scheduler!" -ForegroundColor Red
    Write-Host "Error: $_" -ForegroundColor Red
    Write-Host ""
    Write-Host "[SOLUSI]" -ForegroundColor Yellow
    Write-Host "   1. Pastikan menjalankan PowerShell sebagai Administrator" -ForegroundColor White
    Write-Host "   2. Cek apakah path PHP sudah benar" -ForegroundColor White
    Write-Host "   3. Coba jalankan manual: php artisan schedule:run" -ForegroundColor White
    exit 1
}
