<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - PT. Perkalin Indah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Google Fonts for Icons (Material Symbols) -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <style>
        body { font-family: 'Inter', sans-serif; }
        .material-symbols-outlined { font-size: 20px; }
        /* Custom scrollbar for sidebar */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>
<body class="bg-white text-gray-800" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="absolute inset-y-0 left-0 z-50 w-72 bg-white border-r border-gray-100 transform transition-transform duration-300 ease-in-out md:relative md:translate-x-0 flex flex-col">
            <!-- Logo Section -->
            <div class="h-20 flex items-center px-8 border-b border-gray-50">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 flex items-center justify-center bg-gray-50 rounded-lg overflow-hidden border border-gray-100">
                        @php
                            $logo = \App\Models\Setting::where('key', 'system_logo')->value('value');
                        @endphp
                        @if($logo)
                            <img src="{{ asset($logo) }}" alt="Logo" class="h-full w-full object-contain">
                        @else
                            <div class="p-1.5 bg-red-600 rounded-lg text-white">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                        @endif
                    </div>
                    <div>
                        <h1 class="font-bold text-lg leading-tight text-gray-900">PT. Perkalin Indah</h1>
                        <p class="text-xs text-gray-400">CMS Admin</p>
                    </div>
                </div>
                <button @click="sidebarOpen = false" class="md:hidden ml-auto text-gray-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto            <nav class="p-4 space-y-1">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-red-50 text-red-600' : 'text-gray-500 hover:bg-gray-50 hover:text-red-600' }}">
                    <span class="material-symbols-outlined">dashboard</span>
                    Dashboard
                </a>

                <div class="pt-4 pb-2 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Content</div>

                <!-- Produk -->
                @if(Auth::guard('admin')->user()->hasPermission('product.view'))
                <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-colors {{ request()->routeIs('admin.products.*') ? 'bg-red-50 text-red-600' : 'text-gray-500 hover:bg-gray-50 hover:text-red-600' }}">
                    <span class="material-symbols-outlined">inventory_2</span>
                    Produk
                </a>
                @endif

                <!-- Mitra -->
                @if(Auth::guard('admin')->user()->hasPermission('mitra.view'))
                <a href="{{ route('admin.mitras.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-colors {{ request()->routeIs('admin.mitras.*') ? 'bg-red-50 text-red-600' : 'text-gray-500 hover:bg-gray-50 hover:text-red-600' }}">
                    <span class="material-symbols-outlined">handshake</span>
                    Mitra
                </a>
                @endif

                <!-- Portofolio -->
                @if(Auth::guard('admin')->user()->hasPermission('portfolio.view'))
                <a href="{{ route('admin.portfolios.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-colors {{ request()->routeIs('admin.portfolios.*') ? 'bg-red-50 text-red-600' : 'text-gray-500 hover:bg-gray-50 hover:text-red-600' }}">
                    <span class="material-symbols-outlined">photo_library</span>
                    Portofolio
                </a>
                @endif

                <!-- Page Settings -->
                 @if(Auth::guard('admin')->user()->hasPermission('setting.view'))
                <a href="{{ route('admin.page_settings.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-colors {{ request()->routeIs('admin.page_settings.*') ? 'bg-red-50 text-red-600' : 'text-gray-500 hover:bg-gray-50 hover:text-red-600' }}">
                    <span class="material-symbols-outlined">article</span>
                    Kelola Halaman
                </a>
                @endif

                
                @if(Auth::guard('admin')->user()->hasPermission('setting.view') || Auth::guard('admin')->user()->hasPermission('admin.view'))
                <div class="pt-4 pb-2 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">System</div>
                @endif
                
                <!-- Messages -->
                @if(Auth::guard('admin')->user()->hasPermission('message.view'))
                 <a href="{{ route('admin.messages.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-colors {{ request()->routeIs('admin.messages.*') ? 'bg-red-50 text-red-600' : 'text-gray-500 hover:bg-gray-50 hover:text-red-600' }}">
                    <span class="material-symbols-outlined">mail</span>
                    Pesan Masuk
                    @php
                        $unreadCount = \App\Models\ContactMessage::where('is_read', false)->count();
                    @endphp
                    @if($unreadCount > 0)
                        <span class="ml-auto bg-red-600 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $unreadCount }}</span>
                    @endif
                </a>
                @endif

                <!-- Settings -->
                @if(Auth::guard('admin')->user()->hasPermission('setting.view'))
                <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-colors {{ request()->routeIs('admin.settings.*') ? 'bg-red-50 text-red-600' : 'text-gray-500 hover:bg-gray-50 hover:text-red-600' }}">
                    <span class="material-symbols-outlined">settings</span>
                    Web Profile
                </a>
                @endif
                
                <!-- Admin Management -->
                @if(Auth::guard('admin')->user()->hasPermission('admin.view'))
                <a href="{{ route('admin.roles.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-colors {{ request()->routeIs('admin.roles.*') ? 'bg-red-50 text-red-600' : 'text-gray-500 hover:bg-gray-50 hover:text-red-600' }}">
                    <span class="material-symbols-outlined">security</span>
                    Manajemen Role
                </a>
                <a href="{{ route('admin.admins.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-colors {{ request()->routeIs('admin.admins.*') ? 'bg-red-50 text-red-600' : 'text-gray-500 hover:bg-gray-50 hover:text-red-600' }}">
                    <span class="material-symbols-outlined">supervisor_account</span>
                    Manajemen Admin
                </a>
                @endif
                
                <form action="{{ route('admin.logout') }}" method="POST" class="mt-8 pt-4 border-t border-gray-100">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl text-red-600 hover:bg-red-50 transition-colors">
                        <span class="material-symbols-outlined">logout</span>
                        Sign Out
                    </button>
                </form>
            </nav>
        </aside>

        <!-- Overlay -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/20 backdrop-blur-sm z-40 md:hidden"></div>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col h-screen overflow-hidden bg-white">
            <!-- Header -->
            <header class="h-20 bg-white border-b border-gray-50 flex items-center justify-between px-8 shrink-0">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = true" class="md:hidden text-gray-500 p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <!-- Search Bar
                    <div class="relative hidden md:block">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                             <span class="material-symbols-outlined">search</span>
                        </span>
                        <input type="text" class="bg-gray-50 border-none text-gray-600 text-sm rounded-lg block w-96 pl-10 p-2.5 focus:ring-2 focus:ring-red-100" placeholder="Search products, orders, customers...">
                    </div> -->
                </div>

                <div class="flex items-center gap-6">
                    <button class="text-gray-400 hover:text-gray-600 relative">
                        <span class="material-symbols-outlined">notifications</span>
                        <span class="absolute top-0.5 right-0.5 w-2 h-2 bg-red-500 rounded-full border border-white"></span>
                    </button>
                    
                    <div class="flex items-center gap-3 pl-6 border-l border-gray-100">
                        <div class="text-right hidden md:block">
                             <div class="text-sm font-bold text-gray-900">{{ Auth::guard('admin')->user()->name }}</div>
                             <div class="text-xs text-gray-400">{{ Auth::guard('admin')->user()->email }}</div>
                        </div>
                        <div class="h-10 w-10 rounded-full bg-red-600 text-white flex items-center justify-center font-bold shadow-md shadow-red-200">
                             {{ substr(Auth::guard('admin')->user()->name, 0, 1) }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Body -->
            <div class="flex-1 overflow-y-auto p-8">
                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-3" role="alert">
                         <span class="material-symbols-outlined">check_circle</span>
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-3" role="alert">
                         <span class="material-symbols-outlined">error</span>
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                <div class="max-w-7xl mx-auto">
                    @yield('content')
                </div>

                <footer class="mt-12 text-center text-xs text-gray-400 pb-8">
                    &copy; 2026 PT. Perkalin Indah. CMS Admin Panel v1.0
                </footer>
            </div>
        </main>
    </div>
</body>
</html>
