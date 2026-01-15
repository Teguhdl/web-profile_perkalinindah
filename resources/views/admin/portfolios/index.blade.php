@extends('admin.layouts.app')

@section('title', 'Manajemen Portofolio')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Manajemen Portofolio</h2>
    <a href="{{ route('admin.portfolios.create') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded shadow transition">
        + Tambah Portofolio
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gambar</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul / Klien</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tahun</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($portfolios as $portfolio)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($portfolio->image)
                            <img class="h-12 w-16 rounded object-cover border border-gray-100" src="{{ asset($portfolio->image) }}" alt="{{ $portfolio->title }}">
                        @else
                            <div class="h-12 w-16 rounded bg-gray-100 border border-gray-100 flex items-center justify-center text-xs text-gray-400">No Img</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-semibold text-gray-900">{{ $portfolio->title }}</div>
                        <div class="text-xs text-gray-500">{{ $portfolio->client ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $portfolio->year }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $portfolio->status == 'Publish' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $portfolio->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    @if(Auth::guard('admin')->user()->hasPermission('portfolio.edit'))
                    <a href="{{ route('admin.portfolios.edit', $portfolio->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                    @endif
                    
                    @if(Auth::guard('admin')->user()->hasPermission('portfolio.delete'))
                    <form action="{{ route('admin.portfolios.destroy', $portfolio->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus portofolio ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                    </form>
                    @endif
                </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                        <span class="block material-symbols-outlined text-4xl mb-2 text-gray-300">photo_library</span>
                        Belum ada data portofolio.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-gray-200">
        {{ $portfolios->links() }}
    </div>
</div>
@endsection
