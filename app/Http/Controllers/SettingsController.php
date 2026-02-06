<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings.index');
    }

    public function profile()
    {
        return view('settings.profile');
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone_number' => 'required|string|max:20',
        ]);
        
        $user->update($validated);
        
        return redirect()->route('settings.profile')
            ->with('success', 'Profil berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);
        
        $user = auth()->user();
        
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai']);
        }
        
        $user->update([
            'password' => Hash::make($request->password)
        ]);
        
        return redirect()->route('settings.profile')
            ->with('success', 'Password berhasil diubah!');
    }

    public function whatsapp()
    {
        $waApiKey = Setting::get('wa_api_key', '');
        $waSender = Setting::get('wa_sender', '');
        $waBaseUrl = Setting::get('wa_base_url', 'https://mpwa.mutekar.com');
        $waRecipient = Setting::get('wa_recipient', auth()->user()->phone_number);
        
        return view('settings.whatsapp', compact('waApiKey', 'waSender', 'waBaseUrl', 'waRecipient'));
    }

    public function updateWhatsapp(Request $request)
    {
        $validated = $request->validate([
            'wa_api_key' => 'required|string',
            'wa_sender' => 'required|string',
            'wa_base_url' => 'required|url',
            'wa_recipient' => 'required|string',
        ]);
        
        Setting::set('wa_api_key', $validated['wa_api_key']);
        Setting::set('wa_sender', $validated['wa_sender']);
        Setting::set('wa_base_url', $validated['wa_base_url']);
        Setting::set('wa_recipient', $validated['wa_recipient']);
        
        return redirect()->route('settings.whatsapp')
            ->with('success', 'Pengaturan WhatsApp berhasil disimpan!');
    }

    public function testWhatsapp(Request $request)
    {
        $waApiKey = Setting::get('wa_api_key');
        $waSender = Setting::get('wa_sender');
        $waBaseUrl = Setting::get('wa_base_url');
        $waRecipient = $request->input('test_number') ?: Setting::get('wa_recipient');
        
        if (!$waApiKey || !$waSender || !$waBaseUrl) {
            return response()->json([
                'success' => false,
                'message' => 'Pengaturan WhatsApp belum lengkap'
            ]);
        }
        
        if (!$waRecipient) {
            return response()->json([
                'success' => false,
                'message' => 'Nomor penerima belum diatur'
            ]);
        }
        
        $user = auth()->user();
        
        $message = "🔔 *Test Notifikasi DailyTask*\n\n";
        $message .= "Halo {$user->name}!\n\n";
        $message .= "Ini adalah pesan test dari DailyTask.\n";
        $message .= "Pengaturan WhatsApp Gateway Anda sudah berhasil dikonfigurasi! ✅";
        
        try {
            // Ensure no trailing slash
            $waBaseUrl = rtrim($waBaseUrl, '/');
            
            $response = \Illuminate\Support\Facades\Http::post($waBaseUrl . '/send-message', [
                'api_key' => $waApiKey,
                'sender' => $waSender,
                'number' => $waRecipient,
                'message' => $message
            ]);
            
            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pesan test berhasil dikirim ke ' . $waRecipient
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengirim pesan: ' . $response->body()
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
}
