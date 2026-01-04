@if($portfolios->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
        @foreach($portfolios as $portfolio)
            <div class="bg-white rounded-2xl shadow-md border hover:shadow-xl transition-all duration-300 relative overflow-hidden group border-l-4 border-transparent hover:border-red-600 flex flex-col">
                
                {{-- Image --}}
                <div class="h-48 overflow-hidden relative">
                    @if($portfolio->image)
                        <img src="{{ asset($portfolio->image) }}" alt="{{ $portfolio->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    @else
                        <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400">No Image</div>
                    @endif
                </div>

                <div class="p-8 flex-grow flex flex-col">
                    {{-- Tags --}}
                    <div class="flex space-x-2 mb-4">
                        <span class="bg-[#1e293b] text-white text-xs px-3 py-1 rounded-md">
                            {{ $portfolio->year }}
                        </span>
                        <span class="bg-[#1e293b] text-white text-xs px-3 py-1 rounded-md">
                            {{ $portfolio->status }}
                        </span>
                    </div>

                    {{-- Title --}}
                    <h3 class="text-xl font-bold text-gray-900 mb-4 leading-snug">
                        {{ $portfolio->title }}
                    </h3>

                    {{-- Client --}}
                    <p class="text-xs text-gray-400 uppercase tracking-wide mb-6 mt-auto">
                        {{ $portfolio->client }}
                    </p>

                    {{-- Read More --}}
                    <div>
                        <a href="{{ route('portfolio.detail', $portfolio->id) }}" class="inline-flex items-center text-red-600 font-semibold text-sm hover:underline">
                            Read More 
                            <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- PAGINATION --}}
    <div class="flex justify-center mt-6">
        {{-- IMPORTANT: Use appends to keep query strings in the generated links if standard navigation, 
           but since we use JS override, it's fine. 
           However, standard 'pagination::tailwind' or custom? 
           User liked the custom one. Use 'web.layouts.pagination' --}}
        {{ $portfolios->appends(request()->query())->links('web.layouts.pagination') }}
    </div>

@else
    <div class="text-center py-20 bg-gray-50 rounded-xl border border-dashed border-gray-300">
        <p class="text-gray-500 text-lg">Tidak ada portofolio yang ditemukan.</p>
    </div>
@endif
