<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Admin Perkalin Indah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 flex items-center justify-center h-screen relative overflow-hidden">

    <!-- Background Decoration -->
    <div class="absolute inset-0 z-0 bg-gray-50">
        <div class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-red-600 to-transparent opacity-10"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-red-100 rounded-full blur-3xl opacity-20 transform translate-x-1/2 translate-y-1/2"></div>
        <div class="absolute top-0 left-0 w-64 h-64 bg-gray-200 rounded-full blur-3xl opacity-20 transform -translate-x-1/2 -translate-y-1/2"></div>
    </div>

    <!-- Login Card -->
    <div class="relative z-10 w-full max-w-md px-4">
        <div class="bg-white/95 backdrop-blur-xl rounded-2xl shadow-2xl border border-white/50 p-8 md:p-10 transform hover:scale-[1.01] transition duration-500">
            
            <div class="text-center mb-8">
                <!-- Dynamic Logo -->
                <div class="flex justify-center mb-6">
                    <div class="h-16 w-38">
                        @php
                            $logo = \App\Models\Setting::where('key', 'system_logo')->value('value');
                        @endphp
                        @if($logo)
                            <img src="{{ asset($logo) }}" alt="Logo" class="h-full w-full">
                        @else
                            <span class="material-symbols-outlined text-3xl">admin_panel_settings</span>
                        @endif
                    </div>
                </div>
                
                <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">Admin Portal</h1>
                <p class="text-gray-500 text-sm mt-2 font-medium">PT. Perkalin Indah CMS</p>
            </div>

            @if(session('error'))
                <div class="flex items-center gap-2 bg-red-50 border border-red-100 text-red-600 px-4 py-3 rounded-xl mb-6 text-sm animate-pulse">
                    <span class="material-symbols-outlined text-lg">error</span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label for="email" class="block text-gray-700 text-xs font-bold uppercase tracking-wider mb-2">Email Address</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400 group-focus-within:text-red-500 transition">
                            <span class="material-symbols-outlined text-xl">mail</span>
                        </span>
                        <input type="email" name="email" id="email" required 
                            class="pl-12 w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:ring-2 focus:ring-red-100 focus:border-red-500 transition duration-300"
                            placeholder="name@company.com">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-gray-700 text-xs font-bold uppercase tracking-wider mb-2">Password</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400 group-focus-within:text-red-500 transition">
                            <span class="material-symbols-outlined text-xl">lock</span>
                        </span>
                        <input type="password" name="password" id="password" required 
                            class="pl-12 w-full bg-gray-50 border border-gray-200 rounded-xl py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:ring-2 focus:ring-red-100 focus:border-red-500 transition duration-300"
                            placeholder="••••••••">
                    </div>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-bold py-3.5 px-4 rounded-xl shadow-lg shadow-red-200 hover:shadow-red-300 transform transition hover:-translate-y-0.5 duration-300 flex items-center justify-center gap-2">
                    <span>Sign In</span>
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </button>
            </form>
            
            <div class="mt-8 pt-6 border-t border-gray-100 text-center">
                <p class="text-xs text-gray-400 font-medium">
                    &copy; {{ date('Y') }} PT. Perkalin Indah. All rights reserved.
                </p>
            </div>
        </div>
    </div>

</body>
</html>
