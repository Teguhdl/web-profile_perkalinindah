@extends('admin.layouts.app')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Pesan Masuk</h1>
        <p class="text-sm text-gray-600">Daftar pesan dari form kontak website.</p>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase text-gray-500 font-semibold">
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Nama</th>
                    <th class="px-6 py-4">Email / Telepon</th>
                    <th class="px-6 py-4">Layanan</th>
                    <th class="px-6 py-4">Pesan</th>
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($messages as $msg)
                <tr class="hover:bg-gray-50 {{ !$msg->is_read ? 'bg-blue-50' : '' }}">
                    <td class="px-6 py-4">
                        @if(!$msg->is_read)
                            <span class="inline-block w-2.5 h-2.5 rounded-full bg-blue-600 mr-2"></span>
                            <span class="text-xs font-bold text-blue-600">Baru</span>
                        @else
                            <span class="text-xs text-gray-400">Dibaca</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $msg->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">
                        <div>{{ $msg->email }}</div>
                        <div class="text-xs text-gray-400 mt-1">{{ $msg->phone ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $msg->service ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate">{{ $msg->message }}</td>
                    <td class="px-6 py-4 text-xs text-gray-500">
                        {{ $msg->created_at->format('d M Y, H:i') }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center space-x-2">
                            <a href="{{ route('admin.messages.show', $msg->id) }}" 
                               class="p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition"
                               title="Lihat Detail">
                                <span class="material-symbols-outlined text-lg">visibility</span>
                            </a>
                            <form action="{{ route('admin.messages.destroy', $msg->id) }}" method="POST" onsubmit="return confirm('Hapus pesan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition"
                                        title="Hapus">
                                    <span class="material-symbols-outlined text-lg">delete</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                        Belum ada pesan masuk.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $messages->links() }}
    </div>
</div>
@endsection
