@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8 px-4">
        <div class="bg-white rounded-lg shadow-md p-6 max-w-4xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Tambah Produk/Layanan Baru</h1>
                <a href="{{ route('admin.products.index') }}"
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Kembali
                </a>
            </div>

            @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                    <div class="font-bold">Terdapat kesalahan:</div>
                    <ul class="mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kolom Kiri -->
                    <div class="space-y-6">
                        <!-- Nama Produk/Layanan -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Produk/Layanan *
                            </label>
                            <input type="text" id="title" name="title" value="{{ old('title') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Masukkan nama produk/layanan" required>
                        </div>

                        <!-- Deskripsi Singkat -->
                        <div>
                            <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-2">
                                Deskripsi Singkat
                            </label>
                            <textarea id="meta_description" name="meta_description" rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Deskripsi singkat untuk preview (maksimal 500 karakter)">{{ old('meta_description') }}</textarea>
                            <p class="text-sm text-gray-500 mt-1">Opsional - akan ditampilkan sebagai preview di kartu
                                produk</p>
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                Status *
                            </label>
                            <select id="status" name="status"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                required>
                                <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published
                                </option>
                                <option value="retired" {{ old('status') === 'retired' ? 'selected' : '' }}>Retired</option>
                            </select>
                            <p class="text-sm text-gray-500 mt-1">Draft tidak akan ditampilkan di website, Retired akan
                                masuk ke arsip</p>
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="space-y-6">
                        <!-- Upload Gambar -->
                        <div>
                            <label for="featured_image" class="block text-sm font-medium text-gray-700 mb-2">
                                Gambar Produk/Layanan *
                            </label>
                            <div
                                class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400 transition-colors">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                        viewBox="0 0 48 48">
                                        <path
                                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="featured_image"
                                            class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                            <span>Upload gambar</span>
                                            <input id="featured_image" name="featured_image" type="file" class="sr-only"
                                                accept="image/*" required>
                                        </label>
                                        <p class="pl-1">atau drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF hingga 10MB</p>
                                </div>
                            </div>

                            <!-- Preview Gambar -->
                            <div id="image-preview" class="mt-4 hidden">
                                <img id="preview-img" src="" alt="Preview"
                                    class="max-w-full h-48 object-cover rounded-md border">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Deskripsi Lengkap -->
                <div class="mt-6">
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi Lengkap *
                    </label>
                    <textarea id="content" name="content" rows="8"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Masukkan deskripsi lengkap produk/layanan..." required>{{ old('content') }}</textarea>
                    <p class="text-sm text-gray-500 mt-1">Deskripsi detail yang akan ditampilkan di halaman produk</p>
                </div>

                <!-- Tombol Submit -->
                <div class="mt-8 flex justify-end space-x-3">
                    <a href="{{ route('admin.products.index') }}"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                        Batal
                    </a>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Simpan Produk
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Preview gambar sebelum upload
        document.getElementById('featured_image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-img').src = e.target.result;
                    document.getElementById('image-preview').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
