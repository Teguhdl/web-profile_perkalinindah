<!-- Footer -->
<footer class="bg-[#3d3d3d] text-white py-6">
    <div class="container mx-auto max-w-screen-2xl px-4 sm:px-6 md:px-8 lg:px-12 xl:px-16 2xl:px-24 w-full">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
            <!-- Company Info -->
            <div>
                <div class="flex items-center space-x-3">
                    <img id="main-logo"
                        src="{{ asset('assets/web/logo/logo.png') }}"
                        alt="PT. Perkalin Indah Logo"
                        class="w-[200px] h-30 object-contain transition-all duration-300">
                </div>
                <p class="text-gray-300 text-sm mt-3">
                    {{ $settings['system_slogan'] ?? 'Provider Solution Rubber and Metal Part' }}
                </p>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="font-bold mb-4 text-lg">Quick Links</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-300 hover:text-white transition">Beranda</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white transition">Tentang</a></li>
                    <li><a href="#produk" class="text-gray-300 hover:text-white transition">Produk</a></li>
                    <li><a href="#mitra" class="text-gray-300 hover:text-white transition">Mitra</a></li>
                </ul>
            </div>

            <!-- Social Media -->
            <div>
                <h4 class="font-bold mb-4 text-lg">Social Media</h4>
                <div class="flex space-x-3">
                    @if(isset($settings['social_facebook']))
                    <a href="{{ $settings['social_facebook'] }}" target="_blank" class="w-8 h-8 bg-white/10 rounded flex items-center justify-center hover:bg-blue-600 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path d="M18 2h-3c-1.7 0-3 1.3-3 3v3H9v4h3v10h4V12h3l1-4h-4V5c0-.3.2-1 1-1h3V2z" />
                        </svg>
                    </a>
                    @endif
                    @if(isset($settings['social_instagram']))
                    <a href="{{ $settings['social_instagram'] }}" target="_blank" class="w-8 h-8 bg-white/10 rounded flex items-center justify-center hover:bg-pink-600 transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                        </svg>
                    </a>
                    @endif
                    @if(isset($settings['social_twitter']))
                    <a href="{{ $settings['social_twitter'] }}" target="_blank" class="w-8 h-8 bg-white/10 rounded flex items-center justify-center hover:bg-gray-700 transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                        </svg>
                    </a>
                    @endif
                </div>
            </div>

            <!-- Contact -->
            <div id="kontak">
                <h4 class="font-bold mb-4 text-lg">Contact</h4>
                <ul class="space-y-3 text-gray-300 text-sm">
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-2 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                        </svg>
                        <span>{{ $settings['website_url'] ?? 'www.ptperkalinindah.com' }}</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-2 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>{{ $settings['contact_address'] ?? 'Jl. Cibeurying, Wanilan, Subang, Kabupaten Subang, Jawa Barat 41272' }}</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-2 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <span>{{ $settings['contact_phone'] ?? '(0260) 4641643' }}</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-2 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <div class="flex flex-col">
                            <span>{{ $settings['contact_email'] ?? 'marketing@perkalinindah.com' }}</span>
                             @if(isset($settings['contact_email_2']))
                                <span>{{ $settings['contact_email_2'] }}</span>
                             @endif
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Copyright -->
        <div class="border-t border-gray-600 mt-8 pt-6 text-center text-gray-400 text-sm">
            <p>© {{ date('Y') }} {{ $settings['system_name'] ?? 'PT. Perkalinindah' }}. All rights reserved.</p>
        </div>
    </div>
</footer>