<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;

class ContactMessageController extends Controller
{
    /**
     * Menampilkan daftar pesan kontak
     */
    public function index()
    {
        $messages = ContactMessage::orderBy('created_at', 'desc')->paginate(10);
        return view('back-end.contact-messages.index', compact('messages'));
    }

    /**
     * Menampilkan detail pesan kontak
     */
    public function show(ContactMessage $message)
    {
        // Tandai pesan sebagai telah dibaca
        if (!$message->is_read) {
            $message->update(['is_read' => true]);
        }

        return view('back-end.contact-messages.show', compact('message'));
    }

    /**
     * Menghapus pesan kontak
     */
    public function destroy(ContactMessage $message)
    {
        $message->delete();
        return redirect()->route('admin.contact-messages.index')
            ->with('success', 'Pesan kontak berhasil dihapus!');
    }

    /**
     * Menandai pesan sebagai telah dibaca
     */
    public function markAsRead(ContactMessage $message)
    {
        $message->update(['is_read' => true]);
        return redirect()->back()->with('success', 'Pesan ditandai sebagai telah dibaca.');
    }

    /**
     * Menandai pesan sebagai belum dibaca
     */
    public function markAsUnread(ContactMessage $message)
    {
        $message->update(['is_read' => false]);
        return redirect()->back()->with('success', 'Pesan ditandai sebagai belum dibaca.');
    }
}