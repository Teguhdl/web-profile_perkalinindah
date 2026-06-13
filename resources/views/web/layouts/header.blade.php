<!-- Navigation Header -->
<header id="main-header" class="cke-hd cke-hd--solid transition-all duration-300">
    <div class="cke-hd__inner">
        <!-- Brand / Logo -->
        <a class="cke-hd__brand" href="{{ url('/') }}">
            <img class="cke-hd__logo cke-hd__logo--light" src="{{ asset('assets/web/logo/logo.png') }}" alt="PT. Perkalin Indah" style="height: 52px; width: auto; object-fit: contain;">
            <img class="cke-hd__logo cke-hd__logo--dark" src="{{ asset($settings['system_logo'] ?? 'assets/web/logo/logo.png') }}" alt="PT. Perkalin Indah" style="height: 52px; width: auto; object-fit: contain;">
        </a>

        <style>
            /* Default: transparent header on top of dark hero */
            .cke-hd__logo--light {
                display: block;
            }
            .cke-hd__logo--dark {
                display: none;
            }

            /* Solid header state (scrolled / subpages) */
            .cke-hd--solid .cke-hd__logo--light {
                display: none;
            }
            .cke-hd--solid .cke-hd__logo--dark {
                display: block;
            }
        </style>

        <nav class="cke-hd__nav">
            @foreach ($menus as $menu)
                {{-- MENU TANPA ANAK --}}
                @if ($menu->children->isEmpty())
                    <a href="{{ $menu->slug === '/' ? url('/') : url($menu->slug) }}" class="cke-hd__link">
                        {{ $menu->label }}
                    </a>
                @else
                    {{-- MENU DENGAN DROPDOWN (Native approach for pure CSS fallback) --}}
                    <div class="relative group" style="position:relative; display:inline-block;">
                        <button class="cke-hd__link" style="display:flex; align-items:center; background:none; border:none; cursor:pointer;">
                            {{ $menu->label }}
                            <svg class="w-4 h-4 ml-1" style="width:16px; height:16px; margin-left:4px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div class="dropdown-menu hidden" style="position:absolute; top:100%; left:0; background:var(--surface-card); box-shadow:var(--shadow-md); border-radius:var(--radius-md); padding:0.5rem 0; min-width:180px; z-index:100; border:1px solid var(--border-subtle);">
                            @foreach ($menu->children as $child)
                                <a href="{{ url($child->slug) }}" style="display:block; padding:0.5rem 1rem; color:var(--text-strong); text-decoration:none; font-size:var(--fs-sm); transition:background var(--dur-fast);">
                                    {{ $child->label }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
            <x-cke.button size="sm" variant="primary" href="{{ url('/') }}#kontak">Kontak</x-cke.button>
        </nav>

        <button id="mobile-menu-btn" class="cke-hd__burger" aria-label="Menu">
            @include('web.partials.icon', ['name' => 'menu', 'class' => 'menu-icon-open'])
            @include('web.partials.icon', ['name' => 'x', 'class' => 'menu-icon-close hidden'])
        </button>
    </div>

    <!-- MOBILE MENU -->
    <div id="mobile-menu" class="cke-hd__mobile hidden opacity-0 transition-all duration-300" style="position:absolute; top:100%; left:0; width:100%; background:var(--surface-card); box-shadow:var(--shadow-lg); padding:var(--space-4) var(--space-5); display:flex; flex-direction:column; gap:var(--space-2); border-top:1px solid var(--border-subtle);">
        @foreach ($menus as $menu)
            @if ($menu->children->isEmpty())
                <a href="{{ $menu->slug === '/' ? url('/') : url($menu->slug) }}" style="padding:var(--space-3) 0; font-weight:var(--fw-medium); color:var(--text-strong); border-bottom:1px solid var(--border-subtle); text-decoration:none;">
                    {{ $menu->label }}
                </a>
            @else
                <button class="mobile-dropdown-btn" style="width:100%; display:flex; justify-content:space-between; align-items:center; padding:var(--space-3) 0; font-weight:var(--fw-medium); color:var(--text-strong); background:none; border:none; border-bottom:1px solid var(--border-subtle); cursor:pointer;">
                    {{ $menu->label }}
                    <svg class="w-5 h-5" style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div class="mobile-dropdown-menu hidden" style="padding-left:1rem; border-left:2px solid var(--border-subtle); margin-left:0.5rem; display:flex; flex-direction:column; gap:0.5rem; margin-top:0.5rem;">
                    @foreach ($menu->children as $child)
                        <a href="{{ url($child->slug) }}" style="color:var(--text-muted); text-decoration:none; padding:0.25rem 0;">
                            {{ $child->label }}
                        </a>
                    @endforeach
                </div>
            @endif
        @endforeach
        <div style="margin-top:var(--space-4);">
            <x-cke.button variant="primary" block href="{{ url('/') }}#kontak">Kontak</x-cke.button>
        </div>
    </div>
</header>