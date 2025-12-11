@if($products->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10 mb-12">
        @foreach($products as $product)
        <div class="bg-white rounded-2xl shadow-lg border hover:shadow-2xl transition-all duration-300 overflow-hidden flex flex-col h-full">
            {{-- Image --}}
            <div class="h-64 overflow-hidden relative group">
                @if($product->image)
                    <img src="{{ asset($product->image) }}" 
                         alt="{{ $product->title }}" 
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                @else
                    <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400">
                        No Image
                    </div>
                @endif
                {{-- Red Left Border Accent on Hover --}}
                <div class="absolute left-0 top-0 h-full w-2 bg-red-600 transform -translate-x-2 group-hover:translate-x-0 transition-transform duration-300"></div>
            </div>

            {{-- Content --}}
            <div class="p-6 flex flex-col flex-grow">
                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $product->title }}</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-4 line-clamp-3">
                    {{ $product->content }}
                </p>
                
                <div class="mt-auto">
                    <a href="{{ route('product.detail', $product->slug) }}" class="inline-flex items-center text-red-600 font-semibold hover:text-red-800 transition-colors">
                        Read More 
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- PAGINATION --}}
    <div class="flex justify-center mt-10">
        {{ $products->links('web.layouts.pagination') }}
    </div>

@else
    <div class="text-center py-20">
        <p class="text-gray-500 text-xl">Tidak ada produk yang ditemukan.</p>
    </div>
@endif
