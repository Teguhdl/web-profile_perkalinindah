@extends('web.layouts.master')

@section('content')
<section class="pt-[150px] pb-20 bg-white min-h-screen">
    <div class="container mx-auto px-4 sm:px-6 md:px-8 lg:px-12 xl:px-16 2xl:px-24">
        
        {{-- HEADER TITLE --}}
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-black mb-2">Produk</h1>
            <p class="text-gray-600 text-lg">Temukan Produk yang ingin dicari!</p>
        </div>

        {{-- SEARCH BAR --}}
        <div class="mb-12">
            <form id="search-form" action="{{ url()->current() }}" method="GET" class="relative">
                <input type="text" 
                       id="search-input"
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Search" 
                       class="w-full border border-gray-300 rounded-full px-6 py-4 pl-12 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent shadow-sm text-gray-700 transition-all">
                
                {{-- Search Icon --}}
                <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </form>
        </div>

        {{-- PRODUCTS CONTAINER --}}
        <div id="product-list-container">
            @include('web.pages.partials.product-list', ['products' => $products])
        </div>

    </div>
</section>

{{-- AJAX SCRIPT --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-input');
        const container = document.getElementById('product-list-container');
        let debounceTimer;

        // Function to fetch products
        function fetchProducts(url) {
            // Add loading state opacity
            container.style.opacity = '0.5';

            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                container.innerHTML = html;
                container.style.opacity = '1';
                
                // Re-attach pagination listeners since HTML changed
                attachPaginationListeners();
                
                // Update URL history without reload
                window.history.pushState({}, '', url);
            })
            .catch(error => {
                console.error('Error:', error);
                container.style.opacity = '1';
            });
        }

        // Attach listeners to pagination links
        function attachPaginationListeners() {
            const links = container.querySelectorAll('a.page-link, nav[role="navigation"] a');
            links.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    fetchProducts(this.href);
                });
            });
        }

        // Search Input Listener
        searchInput.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            const query = this.value;
            
            debounceTimer = setTimeout(() => {
                const url = new URL(window.location.href);
                url.searchParams.set('search', query);
                url.searchParams.set('page', 1); // Reset to page 1 on search
                fetchProducts(url.toString());
            }, 500); // 500ms debounce
        });

        // Initial listener attachment
        attachPaginationListeners();
    });
</script>
@endsection