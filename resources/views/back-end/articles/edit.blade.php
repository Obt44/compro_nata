@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8 px-4">
        <div class="bg-white rounded-lg shadow-md p-6 max-w-4xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Edit Artikel</h1>
                <a href="{{ route('admin.articles.index') }}"
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

            <form action="{{ route('admin.articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Judul -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Judul Artikel *</label>
                        <input type="text" id="title" name="title" value="{{ old('title', $article->title) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            required>
                    </div>

                    <!-- Gambar Utama -->
                    <div>
                        <label for="featured_image" class="block text-sm font-medium text-gray-700 mb-2">Gambar
                            Utama</label>
                        <div class="flex items-start">
                            <div class="flex-grow">
                                <input type="file" id="featured_image" name="featured_image" accept="image/*"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <p class="text-sm text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah gambar</p>
                            </div>
                            @if ($article->featured_image)
                                <div class="ml-4 flex-shrink-0">
                                    <img src="{{ asset('storage/' . $article->featured_image) }}"
                                        alt="{{ $article->title }}" class="h-24 w-auto object-cover rounded-md">
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Konten dengan Text Editor -->
                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Konten Artikel *</label>
                        <div id="editor-container" style="height: 400px;"></div>
                        <textarea id="content" name="content" style="display: none;">{{ old('content', $article->content) }}</textarea>
                    </div>

                    <!-- Meta Description -->
                    <div>
                        <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi
                            Singkat</label>
                        <textarea id="meta_description" name="meta_description" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Deskripsi singkat untuk preview artikel...">{{ old('meta_description', $article->meta_description) }}</textarea>
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                        <select id="status" name="status"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            required>
                            <option value="draft" {{ old('status', $article->status) === 'draft' ? 'selected' : '' }}>Draft
                            </option>
                            <option value="published"
                                {{ old('status', $article->status) === 'published' ? 'selected' : '' }}>Terbitkan</option>
                            <option value="retired" {{ old('status', $article->status) === 'retired' ? 'selected' : '' }}>
                                Arsip</option>
                        </select>
                        <p class="mt-1 text-sm text-gray-500">Draft tidak akan ditampilkan di website, Arsip akan masuk ke
                            arsip</p>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Quill.js Text Editor -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

    <script>
        // Initialize Quill editor
        var quill = new Quill('#editor-container', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{
                        'header': [1, 2, 3, 4, 5, 6, false]
                    }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{
                        'color': []
                    }, {
                        'background': []
                    }],
                    [{
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    }],
                    [{
                        'align': []
                    }],
                    ['link', 'image', 'video'],
                    ['clean']
                ]
            },
            placeholder: 'Tulis konten artikel di sini...'
        });

        // Sync Quill content with hidden textarea
        quill.on('text-change', function() {
            document.getElementById('content').value = quill.root.innerHTML;
        });

        // Set initial content if editing
        var initialContent = document.getElementById('content').value;
        if (initialContent) {
            quill.root.innerHTML = initialContent;
        }
    </script>
@endsection
