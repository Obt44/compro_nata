<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\ContactMessage;

class ContactFormController extends Controller
{
    /**
     * Menangani pengiriman form kontak
     */
    public function submit(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        try {
            // Simpan pesan ke database
            $contactMessage = ContactMessage::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'subject' => $validated['subject'],
                'message' => $validated['message'],
                'is_read' => false,
            ]);

            // Log informasi
            Log::info('Form kontak diterima dan disimpan dengan ID: ' . $contactMessage->id);

            // Untuk implementasi selanjutnya, bisa mengirim email notifikasi
            // Contoh kode untuk mengirim email (perlu dikonfigurasi di .env)
            /*
            Mail::raw("Pesan dari: {$validated['name']}\nEmail: {$validated['email']}\nTelepon: {$validated['phone']}\n\n{$validated['message']}", function ($message) use ($validated) {
                $message->to('admin@natatech.com')
                        ->subject("Form Kontak: {$validated['subject']}");
            });
            */

            // Redirect kembali dengan pesan sukses
            return redirect()->back()->with('success', 'Pesan Anda telah berhasil dikirim. Kami akan menghubungi Anda segera.');
        } catch (\Exception $e) {
            // Log error
            Log::error('Error saat mengirim form kontak: ' . $e->getMessage());

            // Redirect kembali dengan pesan error
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengirim pesan. Silakan coba lagi nanti.')->withInput();
        }
    }
}