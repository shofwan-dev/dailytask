<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected $apiKey;
    protected $sender;
    protected $baseUrl;

    public function __construct()
    {
        try {
            // Get settings from database instead of config
            $this->apiKey = Setting::get('wa_api_key', config('services.whatsapp.api_key', ''));
            $this->sender = Setting::get('wa_sender', config('services.whatsapp.sender', ''));
            $this->baseUrl = Setting::get('wa_base_url', config('services.whatsapp.base_url', 'https://mpwa.mutekar.com'));
        } catch (\Exception $e) {
            // Fallback to config if settings table doesn't exist yet (during migration)
            $this->apiKey = config('services.whatsapp.api_key', '');
            $this->sender = config('services.whatsapp.sender', '');
            $this->baseUrl = config('services.whatsapp.base_url', 'https://mpwa.mutekar.com');
        }
    }

    public function sendMessage(string $number, string $message, ?string $footer = null): bool
    {
        try {
            $payload = [
                'api_key' => $this->apiKey,
                'sender' => $this->sender,
                'number' => $this->formatPhoneNumber($number),
                'message' => $message,
            ];

            if ($footer) {
                $payload['footer'] = $footer;
            }

            $response = Http::timeout(30)->post($this->baseUrl . '/send-message', $payload);

            if ($response->successful()) {
                Log::info('WhatsApp message sent successfully', [
                    'number' => $number,
                    'response' => $response->json()
                ]);
                return true;
            }

            Log::error('Failed to send WhatsApp message', [
                'number' => $number,
                'status' => $response->status(),
                'response' => $response->body()
            ]);

            return false;

        } catch (\Exception $e) {
            Log::error('WhatsApp service error', [
                'number' => $number,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    public function sendTaskReminder($task): bool
    {
        // Get recipient from settings (not from task user)
        $recipient = Setting::get('wa_recipient', '');
        
        if (empty($recipient)) {
            Log::warning('WhatsApp recipient not configured in settings');
            return false;
        }
        
        $message = "⏰ *Reminder Task!*\n\n";
        $message .= "👤 *User:* {$task->user->name}\n";
        $message .= "📋 *Task:* {$task->title}\n";
        $message .= "📅 *Deadline:* " . $task->due_date->format('d/m/Y') . " " . \Carbon\Carbon::parse($task->due_time)->format('H:i') . "\n\n";
        
        if ($task->description) {
            $message .= "📝 *Deskripsi:* {$task->description}\n\n";
        }
        
        $message .= "Segera dikerjakan ya! 🚀";

        return $this->sendMessage(
            $recipient,
            $message,
            'DailyTask App'
        );
    }

    protected function formatPhoneNumber(string $number): string
    {
        // Check if it's a Group ID (contains @g.us or is very long)
        if (str_contains($number, '@g.us') || strlen($number) > 15) {
            return $number;
        }

        // Remove any non-numeric characters for regular phone numbers
        $number = preg_replace('/[^0-9]/', '', $number);
        
        // If starts with 0, replace with 62
        if (substr($number, 0, 1) === '0') {
            $number = '62' . substr($number, 1);
        }
        
        // If doesn't start with 62, add it
        if (substr($number, 0, 2) !== '62') {
            $number = '62' . $number;
        }
        
        return $number;
    }
}
