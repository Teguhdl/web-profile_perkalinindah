@extends('web.layouts.master')

@section('content')
<section class="pt-[150px] pb-20 bg-white min-h-screen">
    <div class="container mx-auto px-4 sm:px-6 md:px-8 lg:px-12 xl:px-16 2xl:px-24">
        
        {{-- HEADER --}}
        <div class="mb-10">
            <h1 class="text-4xl font-bold text-black mb-2">Portofolio</h1>
            <p class="text-gray-600 text-lg">Portofolio Perusahaan Kami</p>
        </div>

        {{-- FILTER CARD --}}
        <div class="bg-white rounded-[20px] border border-gray-200 shadow-sm p-6 mb-12">
            <form id="filter-form" class="space-y-6">
                
                {{-- ROW 1: Search & Year & Client --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    {{-- Search Title --}}
                    <div>
                        <label class="block text-red-500 font-semibold mb-2 text-sm">Cari Portofolio</label>
                        <input type="text" name="search" id="input-search" placeholder="Search" 
                               class="w-full border border-red-500 rounded-lg px-4 py-3 focus:outline-none focus:ring-1 focus:ring-red-500">
                    </div>

                    {{-- Year --}}
                    <div>
                        <label class="block text-red-500 font-semibold mb-2 text-sm">Tahun</label>
                        <div class="relative">
                            <select name="year" id="input-year" 
                                    class="w-full border border-red-500 rounded-lg px-4 py-3 appearance-none bg-white focus:outline-none focus:ring-1 focus:ring-red-500">
                                <option value="">Tahun</option>
                                @foreach($years as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>

                     {{-- Client --}}
                    <div>
                        <label class="block text-red-500 font-semibold mb-2 text-sm">Peminta Jasa</label>
                        <input type="text" name="client" id="input-client" placeholder="Search" 
                               class="w-full border border-red-500 rounded-lg px-4 py-3 focus:outline-none focus:ring-1 focus:ring-red-500">
                    </div>
                </div>

                {{-- ROW 2: Buttons --}}
                <div class="flex justify-center gap-4 pt-2">
                    <button type="submit" 
                            class="bg-yellow-400 hover:bg-yellow-500 text-black font-semibold px-10 py-3 rounded-lg shadow-sm transition-colors">
                        Filter
                    </button>
                    <button type="button" id="btn-reset"
                            class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-600 font-semibold px-10 py-3 rounded-lg shadow-sm transition-colors">
                        Reset
                    </button>
                </div>

            </form>
        </div>

        {{-- PORTFOLIO CONTAINER --}}
        <div id="portfolio-list-container">
            @include('web.pages.partials.portfolio-list', ['portfolios' => $portfolios])
        </div>

    </div>
</section>

{{-- AJAX SCRIPT --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterForm = document.getElementById('filter-form');
        const btnReset = document.getElementById('btn-reset');
        const container = document.getElementById('portfolio-list-container');
        
        // Helper to fetch data
        function fetchPortfolios(url, params = {}) {
            container.style.opacity = '0.5';
            
            // Construct URL with params
            const u = new URL(url);
            Object.keys(params).forEach(key => {
                if(params[key]) u.searchParams.append(key, params[key]);
            });

            fetch(u, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.text())
            .then(html => {
                container.innerHTML = html;
                container.style.opacity = '1';
                attachPaginationListeners();
                window.history.pushState({}, '', u);
            })
            .catch(err => {
                console.error(err);
                container.style.opacity = '1';
            });
        }

        // Handle Filter Submit
        filterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const params = {
                search: formData.get('search'),
                year: formData.get('year'),
                client: formData.get('client')
            };
            fetchPortfolios("{{ url()->current() }}", params);
        });

        // Handle Reset
        btnReset.addEventListener('click', function() {
            filterForm.reset();
            fetchPortfolios("{{ url()->current() }}");
        });

        // Handle Pagination
        function attachPaginationListeners() {
            const links = container.querySelectorAll('a.page-link, nav[role="navigation"] a');
            links.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    // Keep current filters when paginating
                    const formData = new FormData(filterForm);
                    const currentParams = {};
                    formData.forEach((value, key) => { if(value) currentParams[key] = value; });
                    
                    // The link href already contains page param, we just need to ensure filters are maintained or fetch handling url correctly
                    // Actually, simpler way: just fetch the link href, but usually you want to append current filters if the link doesn't have them
                    // Since we are using GET form, standard pagination links usually generated with query params IF appended.
                    // But here we are doing JS fetch. 
                    // Let's simplified: The controller `paginate(6)` links won't have the filters unless we use `appends` in Blade.
                    // So we must rely on the Form Data.
                    
                    const url = new URL(this.href);
                    // Merge form params into url params
                    formData.forEach((value, key) => { if(value) url.searchParams.set(key, value); });

                    fetchPortfolios(url.toString());
                });
            });
        }

        attachPaginationListeners();
    });
</script>
@endsection
