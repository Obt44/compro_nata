<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Slide;

class SlideController extends Controller
{
    public function index()
    {
        $slides = Slide::all();
        return view('back-end.slides.index', compact('slides'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'slide_1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'slide_2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'slide_3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        // Proses untuk setiap slide
        for ($i = 1; $i <= 3; $i++) {
            $slide = Slide::firstOrCreate(['position' => $i]);
            
            if ($request->hasFile("slide_{$i}")) {
                // Hapus file lama jika ada
                if ($slide->image_path && Storage::exists('public/' . $slide->image_path)) {
                    Storage::delete('public/' . $slide->image_path);
                }
                
                // Simpan file baru
                $path = $request->file("slide_{$i}")->store('slides', 'public');
                // Pastikan path disimpan dengan benar (tanpa prefix 'public/')
                $slide->image_path = $path;
                $slide->save();
                
                // Log untuk debugging
                \Illuminate\Support\Facades\Log::info("Slide {$i} disimpan dengan path: {$path}");
            }
        }

        return redirect()->route('admin.slides.index')->with('success', 'Slideshow berhasil diperbarui!');
    }
}