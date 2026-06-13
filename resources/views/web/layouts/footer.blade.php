<!-- Footer -->
<footer class="cke-footer">
    <div class="cke-container cke-footer__grid">
        <div class="cke-footer__brand">
            <span class="cke-footer__chip" style="width: auto; height: auto; padding: 6px; background: #fff; border-radius: var(--radius-md);">
                <img src="{{ asset($settings['system_logo'] ?? 'assets/web/logo/logo.png') }}" alt="PT. Perkalin Indah Logo" style="height:42px; width:auto; object-fit:contain;" />
            </span>
            <p class="cke-footer__tag" style="margin-top: 1rem;">
                {{ $settings['system_slogan'] ?? 'Provider Solution Rubber and Metal Part — sejak 1973.' }}
            </p>
            
            <div style="display:flex; gap:0.5rem; margin-top:1.5rem;">
                @if(!empty($settings['social_facebook']))
                <a href="{{ $settings['social_facebook'] }}" target="_blank" style="width:36px; height:36px; background:rgba(255,255,255,0.1); border-radius:var(--radius-md); display:flex; align-items:center; justify-content:center; color:#fff; text-decoration:none; transition:background var(--dur-fast);">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 2h-3c-1.7 0-3 1.3-3 3v3H9v4h3v10h4V12h3l1-4h-4V5c0-.3.2-1 1-1h3V2z" /></svg>
                </a>
                @endif
                @if(!empty($settings['social_instagram']))
                <a href="{{ $settings['social_instagram'] }}" target="_blank" style="width:36px; height:36px; background:rgba(255,255,255,0.1); border-radius:var(--radius-md); display:flex; align-items:center; justify-content:center; color:#fff; text-decoration:none; transition:background var(--dur-fast);">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                </a>
                @endif
                @if(!empty($settings['social_twitter']))
                <a href="{{ $settings['social_twitter'] }}" target="_blank" style="width:36px; height:36px; background:rgba(255,255,255,0.1); border-radius:var(--radius-md); display:flex; align-items:center; justify-content:center; color:#fff; text-decoration:none; transition:background var(--dur-fast);">
                    <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                </a>
                @endif
            </div>
        </div>
        
        <div>
            <h4>Navigasi</h4>
            <ul>
                <li><a href="{{ url('/') }}">Beranda</a></li>
                <li><a href="{{ url('profil-perusahaan') }}">Tentang</a></li>
                <li><a href="{{ url('produk') }}">Produk</a></li>
                <li><a href="{{ url('portofolio') }}">Portofolio</a></li>
                <li><a href="{{ url('mitra') }}">Mitra</a></li>
            </ul>
        </div>
        
        <div>
            <h4>Kategori Produk</h4>
            <ul>
                <li>Sparepart Karet (Rubber)</li>
                <li>Polyurethane Part</li>
                <li>Sparepart Logam (Metal)</li>
                <li>Industrial Plastics</li>
            </ul>
        </div>
        
        <div>
            <h4>Kontak Kami</h4>
            <ul class="cke-footer__contact">
                <li>@include('web.partials.icon', ['name' => 'phone', 'size' => 18]) <span class="vb-contact-phone">{{ $settings['contact_phone'] ?? '(0260) 4641643' }}</span></li>
                <li>@include('web.partials.icon', ['name' => 'mail', 'size' => 18]) <span class="vb-contact-email1">{{ $settings['contact_email_1'] ?? $settings['contact_email'] ?? 'marketing@perkaliindah.com' }}</span></li>
                @if(!empty($settings['contact_email_2']))
                <li>@include('web.partials.icon', ['name' => 'mail', 'size' => 18]) <span class="vb-contact-email2">{{ $settings['contact_email_2'] }}</span></li>
                @endif
                <li>@include('web.partials.icon', ['name' => 'map-pin', 'size' => 18]) <span class="vb-contact-address">{{ $settings['contact_address'] ?? 'Jl. Cibeuying, Wantilan, Subang' }}</span></li>
            </ul>
        </div>
    </div>
    
    <div class="cke-footer__bar">
        <span>© {{ date('Y') }} {{ $settings['system_name'] ?? 'PT. Perkalin Indah' }}. All rights reserved.</span>
    </div>
</footer>