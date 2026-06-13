@extends('web.layouts.master')

@section('content')
<section class="cke-section cke-services" style="padding-top: 120px; background: var(--surface-default); min-height: 100vh;">
    <div class="cke-container">
        <x-cke.section-header align="center" eyebrow="Produk Kami">
            <x-slot name="title">Daftar <em>Produk</em></x-slot>
        </x-cke.section-header>

        {{-- Search & Filter --}}
        <div style="margin-top: 2rem; margin-bottom: 3.5rem; display: flex; justify-content: center; padding: 0 1rem;">
            <form id="search-form" action="{{ url()->current() }}" method="GET" style="position: relative; display: flex; align-items: center; width: 100%; max-width: 500px; background: #fff; border: 1px solid var(--border-default); border-radius: 99px; padding: 6px 6px 6px 20px; box-shadow: var(--shadow-sm); transition: all 0.3s ease;">
                <span style="color: var(--text-muted); display: flex; align-items: center; margin-right: 12px; pointer-events: none;">
                    @include('web.partials.icon', ['name' => 'search', 'size' => 18])
                </span>
                <input type="text" id="search-input" name="search" placeholder="Cari produk kami..." value="{{ request('search') }}" style="flex: 1; border: 0; background: transparent; padding: 8px 0; outline: none; font-size: 15px; color: var(--text-default); font-family: inherit;" onfocus="this.parentElement.style.borderColor = 'var(--color-primary)'; this.parentElement.style.boxShadow = '0 0 0 4px rgba(220, 38, 38, 0.1)';" onblur="this.parentElement.style.borderColor = 'var(--border-default)'; this.parentElement.style.boxShadow = 'var(--shadow-sm)';">
                <button type="submit" class="cke-btn cke-btn--primary" style="border-radius: 99px; padding: 10px 24px; font-size: 14px; font-weight: 600; margin: 0; outline: none; border: 0; cursor: pointer; transition: all 0.2s;">
                    Cari
                </button>
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
        if (searchInput) {
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
        }

        // Initial listener attachment
        attachPaginationListeners();
    });
</script>
@endsection