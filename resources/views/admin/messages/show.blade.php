@extends('admin.layouts.app')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.messages.index') }}" class="flex items-center text-gray-600 hover:text-gray-900 transition mb-4">
        <span class="material-symbols-outlined mr-2">arrow_back</span>
        Kembali ke Pesan Masuk
    </a>
    <h1 class="text-2xl font-bold text-gray-800">Detail Pesan</h1>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden max-w-3xl">
    <div class="p-8 space-y-6">
        
        <!-- Header Info -->
        <div class="flex justify-between items-start border-b border-gray-100 pb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-900">{{ $message->name }}</h2>
                <div class="flex items-center text-sm text-gray-500 mt-1">
                    <span class="material-symbols-outlined text-base mr-1">mail</span>
                    <a href="mailto:{{ $message->email }}" class="hover:text-blue-600 mr-4">{{ $message->email }}</a>
                    
                    @if($message->phone)
                        <span class="material-symbols-outlined text-base mr-1">call</span>
                        <a href="tel:{{ $message->phone }}" class="hover:text-blue-600">{{ $message->phone }}</a>
                    @endif
                </div>
            </div>
            <div class="text-right">
                <span class="text-sm text-gray-500 block">Diterima pada:</span>
                <span class="font-medium text-gray-900">{{ $message->created_at->format('d F Y, H:i') }}</span>
            </div>
        </div>

        <!-- Service Interest -->
        @if($message->service)
        <div class="bg-blue-50 rounded-lg p-4 border border-blue-100">
            <span class="text-xs font-bold text-blue-600 uppercase tracking-wide">Layanan yang Diminati</span>
            <p class="text-blue-900 font-medium mt-1">{{ $message->service }}</p>
        </div>
        @endif

        <!-- Message Body -->
        <div>
            <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wide mb-3">Isi Pesan</h3>
            <div class="p-6 bg-gray-50 rounded-xl border border-gray-200 text-gray-800 leading-relaxed whitespace-pre-wrap">{{ $message->message }}</div>
        </div>

        <!-- Actions -->
        <div class="flex justify-end pt-6 border-t border-gray-100 gap-3">
             <form action="{{ route('admin.messages.destroy', $message->id) }}" method="POST" onsubmit="return confirm('Hapus pesan ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-50 text-red-600 hover:bg-red-100 px-6 py-2 rounded-lg font-semibold transition flex items-center">
                    <span class="material-symbols-outlined mr-2">delete</span>
                    Hapus Pesan
                </button>
            </form>
            <a href="mailto:{{ $message->email }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition flex items-center shadow-md">
                <span class="material-symbols-outlined mr-2">reply</span>
                Balas Email
            </a>
        </div>

    </div>
</div>
@endsection
