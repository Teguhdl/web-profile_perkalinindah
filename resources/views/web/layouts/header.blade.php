<!-- Navigation Header -->
<header id="main-header"
    class="fixed w-full h-[115px] top-0 z-50  flex items-center transition-all duration-300">

    <nav class="container mx-auto px-4 w-full flex items-center justify-between">

        <!-- Logo -->
        <div class="flex items-center space-x-3">
            <img id="main-logo"
                src="{{ asset('assets/web/logo.png') }}"
                alt="PT. Perkalin Indah Logo"
                class="w-[180px] h-20 object-contain transition-all duration-300">
        </div>

        <!-- Desktop Navigation -->
        <div class="hidden md:flex items-center space-x-8">
            <a href="#" class="text-red-600 font-semibold border-b-2 border-red-600 pb-1">Beranda</a>

            <!-- Tentang Dropdown (DESKTOP) -->
            <div class="relative">
                <button id="dropdown-btn-desktop"
                    class="nav-link text-white hover:text-red-600 transition flex items-center">
                    Tentang
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <div id="dropdown-menu-desktop"
                    class="hidden absolute top-full left-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2">
                    <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Profil Perusahaan</a>
                    <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Visi & Misi</a>
                    <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Tim Kami</a>
                </div>
            </div>

            <a href="#produk" class="nav-link text-white hover:text-red-600 transition">Produk</a>
            <a href="#mitra" class="nav-link text-white hover:text-red-600 transition">Mitra</a>

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

        <!-- WRAPPER AGAR ADA JARAK KIRI–KANAN -->
        <div class="px-6 space-y-2">

            <a href="#" class="block py-3 text-black font-medium hover:bg-gray-100 rounded-xl">
                Beranda
            </a>

            <!-- Tentang (Dropdown) -->
            <button id="dropdown-btn-mobile"
                class="w-full flex justify-between items-center py-3 text-black font-medium hover:bg-gray-100 rounded-xl transition">
                Tentang

                <!-- SVG ICON -->
                <svg id="dropdown-icon-mobile" class="w-5 h-5 transition-transform duration-300"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <div id="dropdown-menu-mobile"
                class="hidden pl-4 space-y-2 ml-1 border-l-2 border-gray-300">

                <a href="#" class="block text-black py-2 hover:text-red-600">Profil Perusahaan</a>
                <a href="#" class="block text-black py-2 hover:text-red-600">Visi & Misi</a>
                <a href="#" class="block text-black py-2 hover:text-red-600">Tim Kami</a>

            </div>

            <a href="#produk" class="block py-3 text-black font-medium hover:bg-gray-100 rounded-xl">
                Produk
            </a>

            <a href="#mitra" class="block py-3 text-black font-medium hover:bg-gray-100 rounded-xl">
                Mitra
            </a>

            <a href="#kontak" class="block py-3 text-black font-medium hover:bg-gray-100 rounded-xl">
                Kontak
            </a>

        </div>
    </div>

</header>