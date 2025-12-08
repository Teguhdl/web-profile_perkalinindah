<!-- Navigation Header -->
<header id="main-header"
    class="fixed w-full h-[115px] top-0 z-50  flex items-center transition-all duration-300">

    <nav class="container mx-auto max-w-screen-2xl
    px-4 sm:px-6 md:px-8 lg:px-12 xl:px-16 2xl:px-24 w-full flex items-center justify-between">

        <!-- Logo -->
        <div class="flex items-center space-x-3">
            <img id="main-logo"
                src="{{ asset('assets/web/logo/logo.png') }}"
                alt="PT. Perkalin Indah Logo"
                class="w-[180px] h-20 object-contain transition-all duration-300">
        </div>

        <!-- Desktop Navigation -->
        <div class="hidden md:flex items-center space-x-8">

            @foreach ($menus as $menu)

            {{-- MENU TANPA ANAK --}}
            @if ($menu->children->isEmpty())
            <a href="{{ $menu->slug === '/' ? url('/') : url($menu->slug) }}"
                class="nav-link text-white hover:text-red-600 transition">
                {{ $menu->label }}
            </a>
            @else
            {{-- MENU DENGAN DROPDOWN --}}
            <div class="relative group">
                <button class="nav-link text-white hover:text-red-600 transition flex items-center">
                    {{ $menu->label }}
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div
                    class="hidden group-hover:block absolute top-full left-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2">
                    @foreach ($menu->children as $child)
                    <a href="{{ url($child->slug) }}"
                        class="block px-4 py-2 text-gray-800 hover:bg-gray-100">
                        {{ $child->label }}
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            @endforeach
             <a href="#kontak"
                class="bg-red-600 text-white px-6 py-2 rounded-full hover:bg-red-700 transition font-semibold">
                Kontak
            </a>
        </div>


        <!-- Mobile Menu Button -->
        <button id="mobile-menu-btn" class="md:hidden text-white transition-all duration-300">
            <svg id="mobile-menu-icon" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>

    </nav>

    <!-- MOBILE MENU -->
    <div id="mobile-menu"
        class="hidden opacity-0 absolute top-full left-0 w-full bg-white shadow-xl rounded-b-2xl py-4 px-6 z-50">

        <div class="px-6 space-y-2">

            @foreach ($menus as $menu)

            {{-- MENU TANPA ANAK --}}
            @if ($menu->children->isEmpty())
            <a href="{{ $menu->slug === '/' ? url('/') : url($menu->slug) }}"
                class="block py-3 text-black font-medium hover:bg-gray-100 rounded-xl">
                {{ $menu->label }}
            </a>
            @else
            {{-- MENU DENGAN DROPDOWN --}}
            <button class="w-full flex justify-between items-center py-3 text-black font-medium hover:bg-gray-100 rounded-xl transition">
                {{ $menu->label }}
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div class="hidden pl-4 space-y-2 ml-1 border-l-2 border-gray-300">
                @foreach ($menu->children as $child)
                <a href="{{ url($child->slug) }}"
                    class="block text-black py-2 hover:text-red-600">
                    {{ $child->label }}
                </a>
                @endforeach
            </div>
            @endif

            @endforeach

        </div>
    </div>


</header>