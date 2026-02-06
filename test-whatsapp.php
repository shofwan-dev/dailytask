<?php

/**
 * WhatsApp API Test Script
 * 
 * This script tests the WhatsApp API integration
 * Run: php test-whatsapp.php
 */

require __DIR__.'/vendor/autoload.php';

use Illuminate\Support\Facades\Http;

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

echo "📱 DailyTask - WhatsApp API Test\n";
echo "=================================\n\n";

// Get configuration
$apiKey = $_ENV['WA_API_KEY'] ?? '';
$sender = $_ENV['WA_SENDER'] ?? '';
$baseUrl = $_ENV['WA_BASE_URL'] ?? 'https://mpwa.mutekar.com';

// Validate configuration
if (empty($apiKey) || $apiKey === 'your_api_key_here') {
    echo "❌ Error: WA_API_KEY not configured in .env file\n";
    exit(1);
}

if (empty($sender) || $sender === '628888xxxx') {
    echo "❌ Error: WA_SENDER not configured in .env file\n";
    exit(1);
}

echo "Configuration:\n";
echo "- API Key: " . substr($apiKey, 0, 10) . "...\n";
echo "- Sender: $sender\n";
echo "- Base URL: $baseUrl\n\n";

// Get test number
echo "Enter WhatsApp number to test (format: 628xxx): ";
$testNumber = trim(fgets(STDIN));

if (empty($testNumber)) {
    echo "❌ Error: No number provided\n";
    exit(1);
}

// Format number
$testNumber = preg_replace('/[^0-9]/', '', $testNumber);
if (substr($testNumber, 0, 1) === '0') {
    $testNumber = '62' . substr($testNumber, 1);
}
if (substr($testNumber, 0, 2) !== '62') {
    $testNumber = '62' . $testNumber;
}

echo "\nFormatted number: $testNumber\n";
echo "\nSending test message...\n";

// Prepare payload
$payload = [
    'api_key' => $apiKey,
    'sender' => $sender,
    'number' => $testNumber,
    'message' => "🧪 *Test Message from DailyTask*\n\n" .
                 "Ini adalah test message untuk memastikan integrasi WhatsApp API berfungsi dengan baik.\n\n" .
                 "Jika Anda menerima pesan ini, berarti konfigurasi sudah benar! ✅\n\n" .
                 "Timestamp: " . date('Y-m-d H:i:s'),
    'footer' => 'DailyTask App - Test Mode'
];

// Send request
try {
    $ch = curl_init($baseUrl . '/send-message');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    if ($error) {
        echo "❌ cURL Error: $error\n";
        exit(1);
    }
    
    echo "\nHTTP Status: $httpCode\n";
    echo "Response:\n";
    echo $response . "\n\n";
    
    $responseData = json_decode($response, true);
    
    if ($httpCode === 200) {
        echo "✅ Success! Message sent successfully.\n";
        echo "Check your WhatsApp at $testNumber\n";
    } else {
        echo "❌ Failed to send message.\n";
        if (isset($responseData['message'])) {
            echo "Error: " . $responseData['message'] . "\n";
        }
    }
    
} catch (Exception $e) {
    echo "❌ Exception: " . $e->getMessage() . "\n";
    exit(1);
}

echo "\n=================================\n";
echo "Test completed.\n";
