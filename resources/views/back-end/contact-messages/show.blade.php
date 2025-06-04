@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Detail Pesan Kontak</h1>
        <a href="{{ route('admin.contact-messages.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
            Kembali ke Daftar
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
        <p>{{ session('success') }}</p>
    </div>
    @endif

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="mb-6 pb-6 border-b border-gray-200">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">{{ $message->subject }}</h2>
                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $message->is_read ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                    {{ $message->is_read ? 'Dibaca' : 'Belum Dibaca' }}
                </span>
            </div>
            <p class="text-sm text-gray-500">Diterima pada: {{ $message->created_at->format('d M Y H:i') }}</p>
        </div>

        <div class="mb-6">
            <h3 class="text-lg font-medium mb-2">Informasi Pengirim</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">Nama</p>
                    <p class="mt-1">{{ $message->name }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Email</p>
                    <p class="mt-1">{{ $message->email }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Nomor Telepon</p>
                    <p class="mt-1">{{ $message->phone }}</p>
                </div>
            </div>
        </div>

        <div class="mb-6">
            <h3 class="text-lg font-medium mb-2">Isi Pesan</h3>
            <div class="p-4 bg-gray-50 rounded-lg">
                <p class="whitespace-pre-line">{{ $message->message }}</p>
            </div>
        </div>

        <div class="flex justify-between mt-8">
            <div>
                @if($message->is_read)
                <form action="{{ route('admin.contact-messages.mark-as-unread', $message) }}" method="POST" class="inline">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 mr-2">
                        Tandai Belum Dibaca
                    </button>
                </form>
                @else
                <form action="{{ route('admin.contact-messages.mark-as-read', $message) }}" method="POST" class="inline">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 mr-2">
                        Tandai Dibaca
                    </button>
                </form>
                @endif
            </div>
            
            <form action="{{ route('admin.contact-messages.destroy', $message) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesan ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Hapus Pesan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection