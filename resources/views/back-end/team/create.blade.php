@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="bg-white rounded-lg shadow-md p-6 max-w-4xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Tambah Anggota Tim</h1>
            <p class="text-gray-600 mt-1">Isi formulir di bawah untuk menambahkan anggota tim baru.</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <p class="font-bold">Terjadi kesalahan:</p>
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.team.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Anggota Tim -->
                <div class="col-span-2 md:col-span-1">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Anggota Tim <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                </div>

                <!-- Jabatan -->
                <div class="col-span-2 md:col-span-1">
                    <label for="position" class="block text-sm font-medium text-gray-700 mb-1">Jabatan <span class="text-red-500">*</span></label>
                    <input type="text" name="position" id="position" value="{{ old('position') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                </div>

                <!-- Foto -->
                <div class="col-span-2">
                    <label for="photo" class="block text-sm font-medium text-gray-700 mb-1">Foto</label>
                    <div class="flex items-center">
                        <div class="mr-4">
                            <div id="photo-preview" class="h-32 w-32 bg-gray-200 rounded flex items-center justify-center">
                                <span class="text-gray-400 text-xs">Preview</span>
                            </div>
                        </div>
                        <div class="flex-1">
                            <input type="file" name="photo" id="photo" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500" accept="image/*">
                            <p class="text-xs text-gray-500 mt-1">Format yang didukung: JPG, PNG, GIF. Maksimal 10MB.</p>
                        </div>
                    </div>
                </div>

                <!-- Status -->
                <div class="col-span-2 md:col-span-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <input type="radio" name="active" id="active-yes" value="1" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" {{ old('active', '1') == '1' ? 'checked' : '' }}>
                            <label for="active-yes" class="ml-2 text-sm text-gray-700">Aktif</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" name="active" id="active-no" value="0" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" {{ old('active') == '0' ? 'checked' : '' }}>
                            <label for="active-no" class="ml-2 text-sm text-gray-700">Tidak Aktif</label>
                        </div>
                    </div>
                </div>

                <!-- Urutan -->
                <div class="col-span-2 md:col-span-1">
                    <label for="order" class="block text-sm font-medium text-gray-700 mb-1">Urutan</label>
                    <input type="number" name="order" id="order" value="{{ old('order', 0) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500" min="0">
                    <p class="text-xs text-gray-500 mt-1">Urutan tampilan (opsional, default 0)</p>
                </div>

                <!-- Portofolio -->
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Portofolio</label>
                    <div id="portfolio-items">
                        <div class="portfolio-item mb-2 flex items-center">
                            <input type="text" name="portfolio[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500" placeholder="Masukkan item portofolio">
                            <button type="button" class="remove-portfolio ml-2 text-red-500 hover:text-red-700" style="display: none;">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <button type="button" id="add-portfolio" class="mt-2 inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Tambah Item Portofolio
                    </button>
                </div>
            </div>

            <div class="mt-8 flex justify-end">
                <a href="{{ route('admin.team.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mr-2">
                    Batal
                </a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Photo preview
        const photoInput = document.getElementById('photo');
        const photoPreview = document.getElementById('photo-preview');
        
        photoInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    photoPreview.innerHTML = `<img src="${e.target.result}" class="h-32 w-32 object-cover rounded">`;
                }
                
                reader.readAsDataURL(this.files[0]);
            }
        });
        
        // Portfolio items
        const portfolioItems = document.getElementById('portfolio-items');
        const addPortfolioBtn = document.getElementById('add-portfolio');
        
        // Add portfolio item
        addPortfolioBtn.addEventListener('click', function() {
            addPortfolioItem();
        });
        
        // Remove portfolio item
        portfolioItems.addEventListener('click', function(e) {
            if (e.target.closest('.remove-portfolio')) {
                e.target.closest('.portfolio-item').remove();
                updateRemoveButtons();
            }
        });
        
        function addPortfolioItem() {
            const newItem = document.createElement('div');
            newItem.className = 'portfolio-item mb-2 flex items-center';
            newItem.innerHTML = `
                <input type="text" name="portfolio[]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500" placeholder="Masukkan item portofolio">
                <button type="button" class="remove-portfolio ml-2 text-red-500 hover:text-red-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            `;
            portfolioItems.appendChild(newItem);
            updateRemoveButtons();
        }
        
        function updateRemoveButtons() {
            const items = portfolioItems.querySelectorAll('.portfolio-item');
            items.forEach(item => {
                const removeBtn = item.querySelector('.remove-portfolio');
                if (items.length > 1) {
                    removeBtn.style.display = 'block';
                } else {
                    removeBtn.style.display = 'none';
                }
            });
        }
    });
</script>
@endsection