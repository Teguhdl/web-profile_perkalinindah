@extends('web.layouts.master')

@section('content')
<section class="cke-section cke-projects" style="padding-top: 120px; background: var(--surface-default); min-height: 100vh;">
    <div class="cke-container">
        <x-cke.section-header align="center" eyebrow="Dokumentasi Pekerjaan">
            <x-slot name="title">Proyek yang telah kami <em>selesaikan</em></x-slot>
        </x-cke.section-header>

        {{-- Search & Filter --}}
        <div style="margin-top: 3rem; margin-bottom: 3rem;">
            <form id="filter-form" class="space-y-6" style="display: flex; flex-direction: column; gap: 1.5rem; background: var(--surface-card); padding: 2rem; border-radius: var(--radius-xl); box-shadow: var(--shadow-sm); border: 1px solid var(--border-subtle);">
                
                {{-- Input Fields Row --}}
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
                    
                    {{-- Search Title --}}
                    <div>
                        <x-cke.input type="text" name="search" id="input-search" label="Cari Proyek" placeholder="Kata kunci..." style="margin: 0;" />
                    </div>

                    {{-- Year --}}
                    <div>
                        <label class="cke-field__label" style="display:block; margin-bottom:0.45rem;">Tahun</label>
                        <select name="year" id="input-year" class="cke-field__control" style="cursor: pointer;">
                            <option value="">Semua Tahun</option>
                            @foreach($years as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>

                     {{-- Client --}}
                    <div>
                        <x-cke.input type="text" name="client" id="input-client" label="Peminta Jasa" placeholder="Nama perusahaan..." style="margin: 0;" />
                    </div>
                </div>

                {{-- Buttons Row --}}
                <div style="display: flex; justify-content: center; gap: 1rem;">
                    <x-cke.button type="submit" variant="primary" style="margin: 0; min-width: 150px;">Filter</x-cke.button>
                    <x-cke.button type="button" id="btn-reset" variant="outline" style="margin: 0; min-width: 150px;">Reset</x-cke.button>
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
        if (filterForm) {
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
        }

        // Handle Reset
        if (btnReset) {
            btnReset.addEventListener('click', function() {
                filterForm.reset();
                fetchPortfolios("{{ url()->current() }}");
            });
        }

        // Handle Pagination
        function attachPaginationListeners() {
            const links = container.querySelectorAll('a.page-link, nav[role="navigation"] a');
            links.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const formData = new FormData(filterForm);
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
