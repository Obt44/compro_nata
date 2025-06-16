@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Kelola Informasi Kontak</h1>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('admin.contact.update') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                    <textarea id="address" name="address" rows="3"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ $contact->content ?? '' }}</textarea>
                    @error('address')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="email" name="email"
                        value="{{ $contact && json_decode($contact->meta_description) ? json_decode($contact->meta_description)->email ?? '' : '' }}"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                    <input type="text" id="phone" name="phone"
                        value="{{ $contact && json_decode($contact->meta_description) ? json_decode($contact->meta_description)->phone ?? '' : '' }}"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('phone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="wa_number" class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp</label>
                    <input type="text" id="wa_number" name="wa_number" value="{{ $contact->wa_number ?? '' }}"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('wa_number')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="map_url" class="block text-sm font-medium text-gray-700 mb-1">URL Google Maps Embed</label>
                    <textarea id="map_url" name="map_url" rows="3"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ $contact && json_decode($contact->meta_description) ? json_decode($contact->meta_description)->map_url ?? '' : '' }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Masukkan URL embed Google Maps. Contoh:
                        https://www.google.com/maps/embed?pb=...</p>
                    @error('map_url')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Preview Map</h3>
                    <div class="aspect-w-16 aspect-h-9 bg-gray-100 rounded-lg">
                        <iframe id="map_preview" class="rounded-lg"
                            src="{{ $contact && json_decode($contact->meta_description) ? json_decode($contact->meta_description)->map_url ?? '' : '' }}"
                            width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Simpan
                        Perubahan</button>
                </div>
            </form>
        </div>
    </div>


    {{-- Preview Map --}}
    <script>
        document.getElementById('map_url').addEventListener('input', function() {
            const rawInput = this.value;

            // Coba ambil src dari tag <iframe>
            const match = rawInput.match(/src="([^"]+)"/);

            // Jika ada src, ambil itu. Kalau tidak, pakai nilai langsung
            const cleanedUrl = match ? match[1] : rawInput;

            // Ganti entity seperti &#39; jadi karakter biasa
            const decodedUrl = cleanedUrl
                .replace(/&#39;/g, "'")
                .replace(/&amp;/g, "&")
                .replace(/&quot;/g, '"');

            // Validasi sedikit, hanya set jika mengandung 'maps/embed'
            if (decodedUrl.includes('https://www.google.com/maps/embed?pb=')) {
                document.getElementById('map_preview').src = decodedUrl;
            } else {
                document.getElementById('map_preview').src = '';
            }
        });
    </script>
@endsection
