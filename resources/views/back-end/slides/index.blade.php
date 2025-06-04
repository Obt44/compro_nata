@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="bg-white rounded-lg shadow-md p-6 max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Kelola Slideshow Beranda</h1>
        
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <form action="{{ route('admin.slides.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                @for ($i = 1; $i <= 3; $i++)
                    @php
                        $slide = $slides->where('position', $i)->first();
                        $imagePath = $slide && $slide->image_path ? Storage::url($slide->image_path) : null;
                        
                        // Fallback ke gambar default dari hero.blade.php jika tidak ada di database
                        if (!$imagePath) {
                            $defaultImages = [
                                1 => 'images/image 5.png',
                                2 => 'images/hero-background.jpg',
                                3 => 'images/vision.png'
                            ];
                            $imagePath = asset($defaultImages[$i] ?? '');
                        }
                    @endphp
                    
                    <div class="border rounded-lg p-4">
                        <h3 class="font-semibold text-lg mb-2">Slide {{ $i }}</h3>
                        
                        <div class="mb-4 bg-gray-100 rounded-lg overflow-hidden" style="height: 200px;">
                            <img id="preview_{{ $i }}" src="{{ $imagePath }}" 
                                class="w-full h-full object-cover" alt="Slide {{ $i }}">
                        </div>
                        
                        <div class="mb-2">
                            <label for="slide_{{ $i }}" class="block text-sm font-medium text-gray-700 mb-1">
                                Pilih Gambar Baru
                            </label>
                            <input type="file" name="slide_{{ $i }}" id="slide_{{ $i }}" 
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                onchange="previewImage(this, 'preview_{{ $i }}')">
                        </div>
                        
                        @error("slide_{$i}")
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                @endfor
            </div>
            
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-md transition duration-300">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(input, previewId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                document.getElementById(previewId).src = e.target.result;
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection