@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="bg-white rounded-lg shadow-md p-6 max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Kelola Visi & Misi</h1>
        
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <form action="{{ route('admin.vision-mission.update') }}" method="POST">
            @csrf
            
            <div class="space-y-8">
                <!-- Visi -->
                <div class="border rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Visi Perusahaan</h2>
                    
                    <div class="mb-4">
                        <label for="visi_content" class="block text-sm font-medium text-gray-700 mb-2">
                            Visi *
                        </label>
                        <textarea 
                            id="visi_content" 
                            name="visi_content" 
                            rows="4"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            required
                        >{{ old('visi_content', $visi->content ?? '"Menjadi mitra terpercaya dalam menyediakan solusi TI dengan tepat, inovatif, dan berkelanjutan untuk mewujudkan transformasi digital yang memberikan nilai lebih bagi customer dan stakeholder"') }}</textarea>
                    </div>
                </div>
                
                <!-- Misi -->
                <div class="border rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Misi Perusahaan</h2>
                    
                    <div class="mb-4">
                        <label for="misi_content" class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi Misi *
                        </label>
                        <textarea 
                            id="misi_content" 
                            name="misi_content" 
                            rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            required
                        >{{ old('misi_content', $misi->content ?? 'Menghadirkan solusi teknologi yang inovatif, efisien, dan berkelanjutan untuk membantu klien kami mencapai kesuksesan dalam era digital.') }}</textarea>
                    </div>
                    
                    <div class="mb-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Poin-Poin Misi *
                        </label>
                        
                        @php
                            $misiPoints = $misi && $misi->meta_description ? explode('|', $misi->meta_description) : [
                                'Menyediakan solusi TI yang tepat sasaran dan inovatif',
                                'Menjalin kolaborasi jangka panjang',
                                'Menyelenggarakan tata kelola organisasi yang sehat',
                                'Mengoptimalkan sumber daya perusahaan'
                            ];
                        @endphp
                        
                        <div id="misi_points_container" class="space-y-3">
                            @foreach($misiPoints as $index => $point)
                                <div class="flex items-center">
                                    <input 
                                        type="text" 
                                        name="misi_points[]" 
                                        value="{{ $point }}" 
                                        class="flex-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                        required
                                    >
                                    @if($index > 0)
                                        <button type="button" class="ml-2 text-red-500 hover:text-red-700" onclick="removePoint(this)">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        
                        <button 
                            type="button" 
                            class="mt-3 inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                            onclick="addMisiPoint()"
                        >
                            <svg class="-ml-0.5 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Tambah Poin
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="mt-8 flex justify-end">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function addMisiPoint() {
        const container = document.getElementById('misi_points_container');
        const newPoint = document.createElement('div');
        newPoint.className = 'flex items-center';
        newPoint.innerHTML = `
            <input 
                type="text" 
                name="misi_points[]" 
                class="flex-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                required
            >
            <button type="button" class="ml-2 text-red-500 hover:text-red-700" onclick="removePoint(this)">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </button>
        `;
        container.appendChild(newPoint);
    }
    
    function removePoint(button) {
        const pointElement = button.parentElement;
        pointElement.remove();
    }
</script>
@endsection