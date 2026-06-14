@extends('admin.layouts.app')

@section('title', 'Visual Builder')

@section('content')
{{-- =========================================================
     CSS RESET — Sembunyikan layout admin parent agar fullscreen
     ========================================================== --}}
<style>
    /* Hide parent admin layout elements */
    body > div.flex.h-screen > aside,
    body > div.flex.h-screen > main > header,
    body > div.flex.h-screen > main > div > footer,
    body > div.flex.h-screen > main > div.flex-1 { padding: 0 !important; }
    body > div.flex.h-screen > main > div.flex-1 > .max-w-7xl { max-width: 100% !important; margin: 0 !important; }
    body > div.flex.h-screen > main > div.flex-1 > footer { display: none !important; }
    body > div.flex.h-screen > main > header { display: none !important; }
    body > div.flex.h-screen > aside { display: none !important; }
    body { overflow: hidden !important; }
    body > div.flex.h-screen { height: 100vh !important; }
    body > div.flex.h-screen > main > div.flex-1 { overflow: hidden !important; }
    body > div.flex.h-screen > main > div.flex-1 > div[role="alert"] { display: none !important; }

    /* =========== VISUAL BUILDER STYLES =========== */
    :root {
        --vb-primary: #dc2626;
        --vb-primary-light: #fef2f2;
        --vb-border: #e5e7eb;
        --vb-bg: #f8fafc;
        --vb-text: #0f172a;
        --vb-muted: #64748b;
    }

    .vb-root { font-family: 'Inter', sans-serif; color: var(--vb-text); height: 100vh; display: flex; flex-direction: column; background: var(--vb-bg); }

    /* Scrollbar */
    .vb-scroll::-webkit-scrollbar { width: 6px; height: 6px; }
    .vb-scroll::-webkit-scrollbar-track { background: transparent; }
    .vb-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .vb-scroll::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

    /* HEADER */
    .vb-header { background: #fff; border-bottom: 1px solid var(--vb-border); height: 56px; display: flex; align-items: center; padding: 0 16px; gap: 12px; flex-shrink: 0; }
    .vb-header-btn { width: 36px; height: 36px; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #475569; transition: all .15s; cursor: pointer; border: none; background: transparent; }
    .vb-header-btn:hover { background: #f1f5f9; color: var(--vb-text); }
    .vb-header-divider { width: 1px; height: 22px; background: var(--vb-border); }

    /* MAIN AREA */
    .vb-main { flex: 1; display: flex; overflow: hidden; }

    /* SIDEBAR — left icon nav */
    .vb-icon-nav { width: 64px; background: #fff; border-right: 1px solid var(--vb-border); display: flex; flex-direction: column; padding: 10px 0; gap: 4px; flex-shrink: 0; }
    .vb-icon-btn {
        margin: 0 8px; padding: 8px 0; border-radius: 8px;
        display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 2px;
        color: #64748b; cursor: pointer; transition: all .15s; border: none; background: transparent;
    }
    .vb-icon-btn:hover { background: #f1f5f9; color: var(--vb-text); }
    .vb-icon-btn.active { background: var(--vb-primary); color: #fff; box-shadow: 0 2px 8px rgba(220,38,38,.3); }
    .vb-icon-btn .material-symbols-outlined { font-size: 20px; }
    .vb-icon-btn span:last-child { font-size: 9px; font-weight: 700; letter-spacing: .3px; }

    /* SIDEBAR — form panel */
    .vb-form-panel { width: 340px; background: #fff; border-right: 1px solid var(--vb-border); display: flex; flex-direction: column; flex-shrink: 0; transition: margin-left .3s; }
    .vb-form-panel.collapsed { margin-left: -340px; }

    .vb-form-header { padding: 14px 16px; border-bottom: 1px solid var(--vb-border); background: #fafbfc; }
    .vb-form-header h3 { font-size: 14px; font-weight: 700; color: var(--vb-text); margin: 0; }
    .vb-form-header p  { font-size: 11px; color: var(--vb-muted); margin: 2px 0 0; }

    .vb-form-body { flex: 1; overflow-y: auto; padding: 14px; }

    .vb-panel { display: none; }
    .vb-panel.active { display: block; animation: vbFadeIn .2s ease-out; }
    @keyframes vbFadeIn { from { opacity: 0; transform: translateY(2px); } to { opacity: 1; transform: translateY(0); } }

    /* CARD */
    .vb-card { background: #fff; border: 1px solid var(--vb-border); border-radius: 10px; padding: 14px; margin-bottom: 10px; }
    .vb-card-title { display: flex; align-items: center; gap: 8px; margin-bottom: 12px; }
    .vb-card-title .ico { width: 28px; height: 28px; border-radius: 7px; background: var(--vb-primary-light); color: var(--vb-primary); display: flex; align-items: center; justify-content: center; }
    .vb-card-title .ico .material-symbols-outlined { font-size: 16px; }
    .vb-card-title h4 { font-size: 12px; font-weight: 700; color: var(--vb-text); margin: 0; }
    .vb-card-title p  { font-size: 10px; color: var(--vb-muted); margin: 1px 0 0; }

    /* FIELD */
    .vb-field { margin-bottom: 10px; }
    .vb-field:last-child { margin-bottom: 0; }
    .vb-field label { display: block; font-size: 10px; font-weight: 700; color: #475569; margin-bottom: 5px; text-transform: uppercase; letter-spacing: .4px; }
    .vb-field input, .vb-field textarea {
        width: 100%; padding: 8px 10px; border: 1px solid var(--vb-border); border-radius: 7px;
        font-size: 12px; background: #fff; transition: border-color .15s, box-shadow .15s; font-family: inherit; color: var(--vb-text);
        resize: vertical;
    }
    .vb-field input:focus, .vb-field textarea:focus {
        outline: none; border-color: var(--vb-primary); box-shadow: 0 0 0 3px rgba(220,38,38,.12);
    }

    /* UPLOAD */
    .vb-upload { border: 1.5px dashed var(--vb-border); border-radius: 8px; padding: 14px; text-align: center; cursor: pointer; transition: all .15s; background: #fafbfc; }
    .vb-upload:hover { border-color: var(--vb-primary); background: var(--vb-primary-light); }
    .vb-upload .material-symbols-outlined { font-size: 24px; color: #94a3b8; }
    .vb-upload:hover .material-symbols-outlined { color: var(--vb-primary); }
    .vb-upload p { font-size: 11px; color: #475569; margin: 4px 0 0; font-weight: 600; }
    .vb-upload .fname { font-size: 10px; color: var(--vb-primary); margin-top: 3px; font-weight: 500; }

    /* TOGGLE ROW */
    .vb-toggle-row {
        display: flex; align-items: center; justify-content: space-between;
        padding: 10px 12px; background: #fff; border: 1px solid var(--vb-border);
        border-radius: 8px; margin-bottom: 6px; transition: all .15s;
    }
    .vb-toggle-row:hover { border-color: #cbd5e1; }
    .vb-toggle-row.off { background: #fafbfc; opacity: .65; }
    .vb-toggle-row .left { display: flex; align-items: center; gap: 10px; flex: 1; min-width: 0; }
    .vb-toggle-row .left .material-symbols-outlined { font-size: 18px; color: var(--vb-muted); }
    .vb-toggle-row .left .info { min-width: 0; }
    .vb-toggle-row .left .info .name { font-size: 12px; font-weight: 700; color: var(--vb-text); display: block; }
    .vb-toggle-row .left .info .desc { font-size: 10px; color: var(--vb-muted); display: block; margin-top: 1px; }

    .vb-switch { position: relative; width: 36px; height: 20px; flex-shrink: 0; }
    .vb-switch input { opacity: 0; width: 0; height: 0; }
    .vb-switch .slider { position: absolute; inset: 0; background: #cbd5e1; border-radius: 20px; cursor: pointer; transition: .2s; }
    .vb-switch .slider:before { content: ''; position: absolute; height: 14px; width: 14px; left: 3px; top: 3px; background: #fff; border-radius: 50%; transition: .2s; box-shadow: 0 1px 3px rgba(0,0,0,.2); }
    .vb-switch input:checked + .slider { background: var(--vb-primary); }
    .vb-switch input:checked + .slider:before { transform: translateX(16px); }

    /* PREVIEW AREA */
    .vb-preview { flex: 1; background: #e2e8f0; display: flex; flex-direction: column; align-items: center; padding: 16px; overflow: hidden; }

    .vb-urlbar {
        width: 100%; max-width: 900px; display: flex; align-items: center; gap: 10px;
        background: #fff; border: 1px solid var(--vb-border); border-radius: 999px;
        padding: 6px 14px; margin-bottom: 12px; box-shadow: 0 1px 3px rgba(0,0,0,.05);
    }
    .vb-urlbar .dots { display: flex; gap: 5px; }
    .vb-urlbar .dot { width: 10px; height: 10px; border-radius: 50%; }
    .vb-urlbar .url-display { flex: 1; display: flex; align-items: center; gap: 6px; background: #f8fafc; padding: 5px 12px; border-radius: 999px; font-size: 11px; color: var(--vb-muted); }
    .vb-urlbar .url-display .material-symbols-outlined { font-size: 13px; color: #10b981; }
    .vb-urlbar .badge { font-size: 9px; font-weight: 700; color: #059669; background: #d1fae5; padding: 3px 8px; border-radius: 999px; display: flex; align-items: center; gap: 4px; }
    .vb-urlbar .badge .pulse { width: 5px; height: 5px; background: #10b981; border-radius: 50%; animation: pulseBlink 1.5s infinite; }
    @keyframes pulseBlink { 0%,100% { opacity: 1; } 50% { opacity: .3; } }

    .vb-canvas {
        background: #fff; border: 1px solid #cbd5e1; border-radius: 12px; overflow: hidden;
        box-shadow: 0 20px 50px -15px rgba(0,0,0,.15); position: relative;
        transition: width .35s, height .35s;
        flex: 1; width: 100%;
    }
    .vb-canvas.tablet { width: 820px; max-width: 100%; flex: none; height: calc(100vh - 130px); border-radius: 22px; }
    .vb-canvas.mobile { width: 390px; max-width: 100%; flex: none; height: calc(100vh - 130px); border-radius: 28px; }

    .vb-canvas iframe { width: 100%; height: 100%; border: 0; background: #fff; display: block; }

    .vb-loader { position: absolute; inset: 0; background: rgba(255,255,255,.95); display: flex; align-items: center; justify-content: center; flex-direction: column; gap: 10px; z-index: 50; transition: opacity .3s; backdrop-filter: blur(2px); }
    .vb-loader.hidden { opacity: 0; pointer-events: none; }
    .vb-loader .spin { width: 32px; height: 32px; border: 2.5px solid #fecaca; border-top-color: var(--vb-primary); border-radius: 50%; animation: vbSpin .8s linear infinite; }
    .vb-loader .label { font-size: 10px; font-weight: 700; letter-spacing: 2px; color: var(--vb-muted); }
    @keyframes vbSpin { to { transform: rotate(360deg); } }

    /* DEVICE TOGGLE */
    .vb-device-group { display: flex; gap: 2px; background: #f1f5f9; padding: 3px; border-radius: 8px; }
    .vb-device-btn { padding: 5px 12px; border-radius: 6px; font-size: 11px; font-weight: 600; color: #64748b; transition: all .15s; display: flex; align-items: center; gap: 5px; border: none; background: transparent; cursor: pointer; }
    .vb-device-btn:hover { color: var(--vb-text); }
    .vb-device-btn.active { background: #fff; color: var(--vb-text); box-shadow: 0 1px 2px rgba(0,0,0,.08); }
    .vb-device-btn .material-symbols-outlined { font-size: 14px; }

    /* PUBLISH BUTTON */
    .vb-publish { background: var(--vb-primary); color: #fff; padding: 7px 16px; border-radius: 8px; font-size: 12px; font-weight: 700; display: flex; align-items: center; gap: 6px; border: none; cursor: pointer; transition: all .15s; }
    .vb-publish:hover { background: #b91c1c; box-shadow: 0 4px 12px rgba(220,38,38,.3); transform: translateY(-1px); }
    .vb-publish .material-symbols-outlined { font-size: 16px; }

    /* TOAST */
    .vb-toast { position: fixed; bottom: 20px; right: 20px; background: var(--vb-text); color: #fff; padding: 12px 18px; border-radius: 10px; font-size: 12px; font-weight: 600; display: flex; align-items: center; gap: 8px; z-index: 9999; box-shadow: 0 10px 30px rgba(0,0,0,.25); transform: translateY(100px); opacity: 0; transition: all .3s; }
    .vb-toast.show { transform: translateY(0); opacity: 1; }
    .vb-toast.success { background: #059669; }
    .vb-toast.error { background: var(--vb-primary); }
    .vb-toast .material-symbols-outlined { font-size: 16px; }
</style>

{{-- =========================================================
     STRUCTURE
     ========================================================== --}}
<div class="vb-root">

    {{-- ===== HEADER ===== --}}
    <header class="vb-header">
        <a href="{{ route('admin.dashboard') }}" class="vb-header-btn" title="Tutup Editor">
            <span class="material-symbols-outlined">close</span>
        </a>
        <div class="vb-header-divider"></div>
        <button type="button" onclick="VB.togglePanel()" class="vb-header-btn" title="Sembunyikan Panel">
            <span class="material-symbols-outlined">dock_to_right</span>
        </button>

        <div style="display: flex; align-items: center; gap: 10px; margin-left: 6px;">
            <span style="width: 8px; height: 8px; background: #10b981; border-radius: 50%; animation: pulseBlink 1.5s infinite;"></span>
            <div>
                <h2 style="font-size: 13px; font-weight: 700; color: var(--vb-text); margin: 0; line-height: 1.1;">Visual Page Builder</h2>
                <p style="font-size: 10px; color: var(--vb-muted); margin: 1px 0 0; line-height: 1;">Editing: <span id="vb-page-label" style="font-weight: 600; color: #475569;">Beranda Utama</span></p>
            </div>
        </div>

        <div style="flex: 1;"></div>

        {{-- Device Switcher --}}
        <div class="vb-device-group">
            <button type="button" onclick="VB.setDevice('desktop')" id="vb-btn-desktop" class="vb-device-btn active">
                <span class="material-symbols-outlined">desktop_windows</span> Desktop
            </button>
            <button type="button" onclick="VB.setDevice('tablet')" id="vb-btn-tablet" class="vb-device-btn">
                <span class="material-symbols-outlined">tablet_mac</span> Tablet
            </button>
            <button type="button" onclick="VB.setDevice('mobile')" id="vb-btn-mobile" class="vb-device-btn">
                <span class="material-symbols-outlined">smartphone</span> Mobile
            </button>
        </div>

        <div style="flex: 1;"></div>

        <button type="button" onclick="VB.reloadPreview()" class="vb-header-btn" title="Muat Ulang">
            <span class="material-symbols-outlined">refresh</span>
        </button>
        <button type="button" onclick="document.getElementById('vb-form').requestSubmit()" class="vb-publish">
            <span class="material-symbols-outlined">cloud_upload</span> Publikasikan
        </button>
    </header>

    {{-- ===== MAIN ===== --}}
    <div class="vb-main">

        {{-- ===== LEFT: ICON NAV ===== --}}
        <nav class="vb-icon-nav">
            <button type="button" onclick="VB.switchTab('home')" id="vb-tab-home" class="vb-icon-btn active">
                <span class="material-symbols-outlined">home</span><span>Beranda</span>
            </button>
            <button type="button" onclick="VB.switchTab('profile')" id="vb-tab-profile" class="vb-icon-btn">
                <span class="material-symbols-outlined">business</span><span>Profil</span>
            </button>
            <button type="button" onclick="VB.switchTab('vision')" id="vb-tab-vision" class="vb-icon-btn">
                <span class="material-symbols-outlined">flag</span><span>Visi</span>
            </button>
            <button type="button" onclick="VB.switchTab('team')" id="vb-tab-team" class="vb-icon-btn">
                <span class="material-symbols-outlined">groups</span><span>Tim</span>
            </button>
            <div style="height: 1px; background: var(--vb-border); margin: 6px 12px;"></div>
            <button type="button" onclick="VB.switchTab('contact')" id="vb-tab-contact" class="vb-icon-btn">
                <span class="material-symbols-outlined">call</span><span>Kontak</span>
            </button>
            <button type="button" onclick="VB.switchTab('layout')" id="vb-tab-layout" class="vb-icon-btn">
                <span class="material-symbols-outlined">view_quilt</span><span>Layout</span>
            </button>
        </nav>

        {{-- ===== MIDDLE: FORM PANEL ===== --}}
        <aside id="vb-form-panel" class="vb-form-panel">
            <div class="vb-form-header">
                <h3 id="vb-section-title">Halaman Beranda</h3>
                <p id="vb-section-desc">Atur konten halaman utama</p>
            </div>

            <div class="vb-form-body vb-scroll">
                <form id="vb-form" action="{{ route('admin.page_settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- ============ BERANDA ============ --}}
                    <div id="vb-panel-home" class="vb-panel active">
                        <div class="vb-card">
                            <div class="vb-card-title">
                                <div class="ico"><span class="material-symbols-outlined">view_carousel</span></div>
                                <div><h4>Banner Hero</h4><p>Judul utama di atas halaman</p></div>
                            </div>
                            <div class="vb-field">
                                <label>Judul Utama</label>
                                <input type="text" id="in_hero_title" name="dashboard_hero_title" value="{{ $settings['dashboard_hero_title'] ?? '' }}" placeholder="Contoh: Solusi Terbaik untuk Bisnis Anda">
                            </div>
                            <div class="vb-field">
                                <label>Subjudul / Deskripsi</label>
                                <textarea id="in_hero_subtitle" name="dashboard_hero_subtitle" rows="3" placeholder="Tagline pendek pendukung">{{ $settings['dashboard_hero_subtitle'] ?? '' }}</textarea>
                            </div>
                            <div class="vb-field">
                                <label>Gambar Background Hero</label>
                                <div class="vb-upload" onclick="document.getElementById('in_hero_image').click()">
                                    <span class="material-symbols-outlined">add_photo_alternate</span>
                                    <p>Ganti Gambar Background</p>
                                    <p class="fname" id="fn_hero_image"></p>
                                </div>
                                <input type="file" id="in_hero_image" name="dashboard_hero_image" accept="image/*" style="display:none" onchange="VB.previewLocalImage(this, '.cke-hero__media', 'fn_hero_image')">
                            </div>
                        </div>

                        <div class="vb-card">
                            <div class="vb-card-title">
                                <div class="ico"><span class="material-symbols-outlined">info</span></div>
                                <div><h4>Tentang Kami</h4><p>Pengenalan singkat perusahaan</p></div>
                            </div>
                            <div class="vb-field">
                                <label>Judul Bagian</label>
                                <input type="text" id="in_about_title" name="dashboard_about_title" value="{{ $settings['dashboard_about_title'] ?? '' }}" placeholder="Contoh: Mitra terpercaya untuk [produk karet & logam] Anda">
                                <span style="display: block; font-size: 11px; color: #64748b; margin-top: 4px;">Gunakan kurung siku <code>[kata yang ingin disorot]</code> untuk memberikan warna sorotan pada kata tertentu. Contoh: <code>Mitra terpercaya untuk [produk karet & logam] Anda</code>. Jika ingin kata di dalam sorotan berwarna normal, tambahkan span: <code>Mitra terpercaya untuk [produk &lt;span&gt;karet&lt;/span&gt; &amp; logam] Anda</code></span>
                            </div>
                            <div class="vb-field">
                                <label>Pills / Keahlian (Pisahkan dengan koma)</label>
                                <input type="text" id="in_about_tags" name="dashboard_about_tags" value="{{ $settings['dashboard_about_tags'] ?? '' }}" placeholder="Contoh: Rubber Part, Polyurethane, Metal Sparepart">
                            </div>
                            <div class="vb-field" style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                                <div>
                                    <label>Warna Judul</label>
                                    <input type="color" id="in_about_title_color" name="dashboard_about_title_color" value="{{ $settings['dashboard_about_title_color'] ?? '#0f172a' }}" style="height: 38px; padding: 2px; cursor: pointer;">
                                </div>
                                <div>
                                    <label>Warna Sorotan</label>
                                    <input type="color" id="in_about_title_highlight_color" name="dashboard_about_title_highlight_color" value="{{ $settings['dashboard_about_title_highlight_color'] ?? '#dc2626' }}" style="height: 38px; padding: 2px; cursor: pointer;">
                                </div>
                            </div>
                            <div class="vb-field">
                                <label>Konten Teks</label>
                                <textarea name="page_about_content" class="summernote" data-target-sel="#tentang-kami-content">{{ $settings['page_about_content'] ?? '' }}</textarea>
                            </div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                                <div>
                                    <label style="display: block; font-size: 10px; font-weight: 700; color: #475569; margin-bottom: 5px; text-transform: uppercase; letter-spacing: .4px;">Gambar Kanan</label>
                                    <div class="vb-upload" onclick="document.getElementById('in_about_img1').click()">
                                        <span class="material-symbols-outlined">add_photo_alternate</span>
                                        <p>Ganti Gambar 1</p>
                                        <p class="fname" id="fn_img1"></p>
                                    </div>
                                    <input type="file" id="in_about_img1" name="dashboard_about_image_1" accept="image/*" style="display:none" onchange="VB.previewLocalImage(this, '#tentang-img-1', 'fn_img1')">
                                </div>
                                <div>
                                    <label style="display: block; font-size: 10px; font-weight: 700; color: #475569; margin-bottom: 5px; text-transform: uppercase; letter-spacing: .4px;">Gambar Kiri</label>
                                    <div class="vb-upload" onclick="document.getElementById('in_about_img2').click()">
                                        <span class="material-symbols-outlined">add_photo_alternate</span>
                                        <p>Ganti Gambar 2</p>
                                        <p class="fname" id="fn_img2"></p>
                                    </div>
                                    <input type="file" id="in_about_img2" name="dashboard_about_image_2" accept="image/*" style="display:none" onchange="VB.previewLocalImage(this, '#tentang-img-2', 'fn_img2')">
                                </div>
                            </div>
                        </div>

                        <div class="vb-card">
                            <div class="vb-card-title">
                                <div class="ico"><span class="material-symbols-outlined">smart_display</span></div>
                                <div><h4>Video Profil</h4><p>Video presentasi perusahaan</p></div>
                            </div>
                            <div class="vb-field">
                                <label>Judul Bagian Video</label>
                                <input type="text" id="in_video_title" name="dashboard_video_title" value="{{ $settings['dashboard_video_title'] ?? '' }}">
                            </div>
                            <div class="vb-field">
                                <label>Deskripsi</label>
                                <textarea id="in_video_desc" name="dashboard_video_desc" rows="2">{{ $settings['dashboard_video_desc'] ?? '' }}</textarea>
                            </div>
                            <div class="vb-upload" onclick="document.getElementById('in_video_file').click()">
                                <span class="material-symbols-outlined">movie</span>
                                <p>Upload File Video (MP4)</p>
                                <p class="fname" id="fn_video"></p>
                            </div>
                            <input type="file" id="in_video_file" name="dashboard_video_url" accept="video/mp4" style="display:none">
                        </div>
                    </div>

                    {{-- ============ PROFIL ============ --}}
                    <div id="vb-panel-profile" class="vb-panel">
                        <div class="vb-card">
                            <div class="vb-card-title">
                                <div class="ico"><span class="material-symbols-outlined">corporate_fare</span></div>
                                <div><h4>Sejarah Perusahaan</h4><p>Cerita pendirian & perjalanan</p></div>
                            </div>
                            <textarea name="page_company_profile_content" class="summernote" data-target-sel="#profile-company-content">{{ $settings['page_company_profile_content'] ?? '' }}</textarea>
                        </div>
                        <div class="vb-card">
                            <div class="vb-card-title">
                                <div class="ico"><span class="material-symbols-outlined">image</span></div>
                                <div><h4>Galeri Gambar & Badge</h4><p>2 gambar & badge tahun di sisi kanan profil</p></div>
                            </div>                            {{-- Toggle Show Gallery --}}
                            @php $galleryOn = ($settings['profile_show_gallery'] ?? '1') == '1'; @endphp
                            <div class="vb-toggle-row {{ $galleryOn ? '' : 'off' }}" id="row_profile_show_gallery" style="margin-bottom:12px;">
                                <div class="left">
                                    <span class="material-symbols-outlined">photo_library</span>
                                    <div class="info">
                                        <span class="name">Tampilkan Galeri</span>
                                        <span class="desc">On/Off seluruh gambar</span>
                                    </div>
                                </div>
                                <label class="vb-switch">
                                    <input type="checkbox" id="tg_profile_show_gallery" name="profile_show_gallery" value="1"
                                           data-key="profile_show_gallery" data-target="#profile-gallery"
                                           {{ $galleryOn ? 'checked' : '' }} onchange="VB.handleToggle(this)">
                                    <span class="slider"></span>
                                </label>
                            </div>

                            <div style="display:grid; grid-template-columns:1fr 1fr; gap:8px;">
                                @php
                                    $profileImgs = [
                                        ['profile_image_main', 'Gambar Belakang (Besar)', 'in_profile_img_main', 'fn_profile_main', '#profile-gallery .cke-about__photo--back'],
                                        ['profile_image_1',    'Gambar Depan (Kecil)',    'in_profile_img_1',    'fn_profile_1',    '#profile-gallery .cke-about__photo--front'],
                                    ];
                                @endphp
                                @foreach($profileImgs as $pi)
                                <div>
                                    <label style="display:block; font-size:10px; font-weight:700; color:#475569; margin-bottom:5px; text-transform:uppercase; letter-spacing:.4px;">{{ $pi[1] }}</label>
                                    <div class="vb-upload" onclick="document.getElementById('{{ $pi[2] }}').click()">
                                        <span class="material-symbols-outlined">add_photo_alternate</span>
                                        <p>Ganti</p>
                                        <p class="fname" id="{{ $pi[3] }}"></p>
                                    </div>
                                    <input type="file" id="{{ $pi[2] }}" name="{{ $pi[0] }}" accept="image/*" style="display:none"
                                           onchange="VB.previewLocalImage(this, '{{ $pi[4] }}', '{{ $pi[3] }}')">
                                </div>
                                @endforeach
                            </div>
                            <div style="display:grid; grid-template-columns:1fr 1fr; gap:8px; margin-top:12px; border-top:1px solid var(--vb-border); padding-top:12px;">
                                <div class="vb-field">
                                    <label>Teks Badge (Tahun)</label>
                                    <input type="text" id="in_profile_badge_num" name="profile_badge_number" value="{{ $settings['profile_badge_number'] ?? '1973' }}">
                                </div>
                                <div class="vb-field">
                                    <label>Label Badge (Teks)</label>
                                    <input type="text" id="in_profile_badge_lbl" name="profile_badge_label" value="{{ $settings['profile_badge_label'] ?? 'Tahun Berdiri' }}">
                                </div>
                            </div>
                            <div style="display:grid; grid-template-columns:1fr 1fr; gap:8px; margin-top:12px;">
                                <div class="vb-field">
                                    <label>Warna Background Badge</label>
                                    <div style="display:flex; gap:6px; align-items:center;">
                                        <input type="color" id="in_profile_badge_bg_color" name="profile_badge_bg_color" value="{{ $settings['profile_badge_bg_color'] ?? '#0f172a' }}" style="width:40px; height:36px; padding:0; border:1px solid var(--vb-border); border-radius:6px; cursor:pointer;" oninput="document.getElementById('txt_profile_badge_bg_color').value = this.value; document.getElementById('in_profile_badge_bg_color').dispatchEvent(new Event('input'))">
                                        <input type="text" id="txt_profile_badge_bg_color" value="{{ $settings['profile_badge_bg_color'] ?? '#0f172a' }}" style="flex:1;" oninput="document.getElementById('in_profile_badge_bg_color').value = this.value; document.getElementById('in_profile_badge_bg_color').dispatchEvent(new Event('input'))">
                                    </div>
                                </div>
                                <div class="vb-field">
                                    <label>Warna Angka Badge</label>
                                    <div style="display:flex; gap:6px; align-items:center;">
                                        <input type="color" id="in_profile_badge_text_color" name="profile_badge_text_color" value="{{ $settings['profile_badge_text_color'] ?? '#b6d335' }}" style="width:40px; height:36px; padding:0; border:1px solid var(--vb-border); border-radius:6px; cursor:pointer;" oninput="document.getElementById('txt_profile_badge_text_color').value = this.value; document.getElementById('in_profile_badge_text_color').dispatchEvent(new Event('input'))">
                                        <input type="text" id="txt_profile_badge_text_color" value="{{ $settings['profile_badge_text_color'] ?? '#b6d335' }}" style="flex:1;" oninput="document.getElementById('in_profile_badge_text_color').value = this.value; document.getElementById('in_profile_badge_text_color').dispatchEvent(new Event('input'))">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="vb-card">
                            <div class="vb-card-title">
                                <div class="ico"><span class="material-symbols-outlined">verified</span></div>
                                <div><h4>Sertifikasi & Lokasi</h4><p>Info sertifikat & cabang</p></div>
                            </div>
                            <textarea name="page_profile_cert_content" class="summernote" data-target-sel="#profile-cert-content">{{ $settings['page_profile_cert_content'] ?? '' }}</textarea>
                        </div>
                    </div>

                    {{-- ============ VISI MISI ============ --}}
                    <div id="vb-panel-vision" class="vb-panel">
                        <div class="vb-card">
                            <div class="vb-card-title">
                                <div class="ico"><span class="material-symbols-outlined">visibility</span></div>
                                <div><h4>Visi Perusahaan</h4><p>Tujuan jangka panjang</p></div>
                            </div>
                            <textarea name="page_visi_content" class="summernote" data-target-sel="#visi-content">{{ $settings['page_visi_content'] ?? '' }}</textarea>
                        </div>
                        <div class="vb-card">
                            <div class="vb-card-title">
                                <div class="ico"><span class="material-symbols-outlined">checklist</span></div>
                                <div><h4>Misi Perusahaan</h4><p>Strategi mencapai visi</p></div>
                            </div>
                            <textarea name="page_misi_content" class="summernote" data-target-sel="#misi-content">{{ $settings['page_misi_content'] ?? '' }}</textarea>
                        </div>
                    </div>

                    {{-- ============ TIM ============ --}}
                    <div id="vb-panel-team" class="vb-panel">
                        <div class="vb-card">
                            <div class="vb-card-title">
                                <div class="ico"><span class="material-symbols-outlined">account_tree</span></div>
                                <div><h4>Struktur Organisasi</h4><p>Upload bagan dalam PDF</p></div>
                            </div>
                            <div class="vb-upload" onclick="document.getElementById('in_pdf_file').click()">
                                <span class="material-symbols-outlined">picture_as_pdf</span>
                                <p>Pilih File PDF</p>
                                <p class="fname" id="fn_pdf"></p>
                            </div>
                            <input type="file" id="in_pdf_file" name="page_team_pdf" accept="application/pdf" style="display:none">
                        </div>
                    </div>

                    {{-- ============ KONTAK ============ --}}
                    <div id="vb-panel-contact" class="vb-panel">
                        <div class="vb-card">
                            <div class="vb-card-title">
                                <div class="ico"><span class="material-symbols-outlined">call</span></div>
                                <div><h4>Informasi Kontak</h4><p>Telepon, email & alamat</p></div>
                            </div>
                             <div class="vb-field">
                                <label>Nomor Telepon</label>
                                <input type="text" id="in_contact_phone" name="contact_phone" value="{{ $settings['contact_phone'] ?? '' }}" placeholder="+62 ..." data-target-sel=".vb-contact-phone">
                            </div>
                            <div class="vb-field">
                                <label>Email Utama</label>
                                <input type="email" id="in_contact_email_1" name="contact_email_1" value="{{ $settings['contact_email_1'] ?? '' }}" placeholder="info@example.com" data-target-sel=".vb-contact-email1">
                            </div>
                            <div class="vb-field">
                                <label>Email Sekunder</label>
                                <input type="email" id="in_contact_email_2" name="contact_email_2" value="{{ $settings['contact_email_2'] ?? '' }}" placeholder="cs@example.com" data-target-sel=".vb-contact-email2">
                            </div>
                            <div class="vb-field">
                                <label>Alamat Kantor</label>
                                <textarea id="in_contact_address" name="contact_address" rows="3" data-target-sel=".vb-contact-address">{{ $settings['contact_address'] ?? '' }}</textarea>
                            </div>

                        </div>
                        <div class="vb-card">
                            <div class="vb-card-title">
                                <div class="ico"><span class="material-symbols-outlined">schedule</span></div>
                                <div><h4>Jam Operasional</h4><p>Waktu buka layanan</p></div>
                            </div>
                            <div class="vb-field">
                                <label>Senin - Jumat</label>
                                <input type="text" id="in_contact_hours_mon_fri" name="contact_hours_mon_fri" value="{{ $settings['contact_hours_mon_fri'] ?? '' }}" placeholder="08:00 - 17:00" data-target-sel=".vb-contact-hours-mon-fri">
                            </div>
                            <div class="vb-field">
                                <label>Sabtu</label>
                                <input type="text" id="in_contact_hours_sat" name="contact_hours_sat" value="{{ $settings['contact_hours_sat'] ?? '' }}" placeholder="08:00 - 13:00" data-target-sel=".vb-contact-hours-sat">
                            </div>
                        </div>
                    </div>

                    {{-- ============ LAYOUT — TOGGLE SECTION ============ --}}
                    <div id="vb-panel-layout" class="vb-panel">
                        <div class="vb-card">
                            <div class="vb-card-title">
                                <div class="ico"><span class="material-symbols-outlined">tune</span></div>
                                <div><h4>Tampilkan / Sembunyikan Section</h4><p>Perubahan langsung di preview</p></div>
                            </div>

                            @php
                                $toggles = [
                                    'dashboard_show_hero'     => ['Banner Hero',      'Banner besar di atas halaman',     'view_carousel',  '#beranda'],
                                    'dashboard_show_about'    => ['Tentang Kami',     'Deskripsi & 2 gambar perusahaan',  'info',           '#tentang'],
                                    'dashboard_show_video'    => ['Video Profil',     'Player video promosi',             'smart_display',  '#video-kami'],
                                    'dashboard_show_products' => ['Produk Unggulan',  'Grid 6 produk terbaru',            'inventory_2',    '#product-unggulan'],
                                    'dashboard_show_mitra'    => ['Mitra Kami',       'Logo mitra scroll horizontal',     'handshake',      '#mitra'],
                                ];
                            @endphp

                            @foreach($toggles as $key => $t)
                                @php $isOn = ($settings[$key] ?? '1') == '1'; @endphp
                                <div class="vb-toggle-row {{ $isOn ? '' : 'off' }}" id="row_{{ $key }}">
                                    <div class="left">
                                        <span class="material-symbols-outlined">{{ $t[2] }}</span>
                                        <div class="info">
                                            <span class="name">{{ $t[0] }}</span>
                                            <span class="desc">{{ $t[1] }}</span>
                                        </div>
                                    </div>
                                    <label class="vb-switch">
                                        <input type="checkbox"
                                               id="tg_{{ $key }}"
                                               name="{{ $key }}"
                                               value="1"
                                               data-key="{{ $key }}"
                                               data-target="{{ $t[3] }}"
                                               {{ $isOn ? 'checked' : '' }}
                                               onchange="VB.handleToggle(this)">
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            @endforeach

                            <div style="margin-top: 10px; padding: 10px; background: var(--vb-primary-light); border-radius: 8px; display: flex; gap: 8px; align-items: flex-start;">
                                <span class="material-symbols-outlined" style="font-size: 16px; color: var(--vb-primary);">bolt</span>
                                <p style="font-size: 11px; color: #7f1d1d; margin: 0; line-height: 1.4;">
                                    <strong>Auto-save aktif:</strong> Perubahan toggle langsung tersimpan otomatis & efeknya muncul di preview.
                                </p>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </aside>

        {{-- ===== RIGHT: LIVE PREVIEW ===== --}}
        <main class="vb-preview">
            <div class="vb-urlbar">
                <div class="dots">
                    <span class="dot" style="background:#f87171"></span>
                    <span class="dot" style="background:#fbbf24"></span>
                    <span class="dot" style="background:#34d399"></span>
                </div>
                <div class="url-display">
                    <span class="material-symbols-outlined">lock</span>
                    <span id="vb-url-display">{{ url('/') }}</span>
                </div>
                <span class="badge"><span class="pulse"></span> LIVE</span>
            </div>

            <div id="vb-canvas" class="vb-canvas">
                <div class="vb-loader" id="vb-loader">
                    <div class="spin"></div>
                    <div class="label">MEMUAT CANVAS</div>
                </div>
                <iframe id="vb-iframe" src="{{ url('/') }}" onload="VB.onIframeLoad(this)"></iframe>
            </div>
        </main>
    </div>
</div>

{{-- TOAST --}}
<div id="vb-toast" class="vb-toast">
    <span class="material-symbols-outlined" id="vb-toast-icon">check_circle</span>
    <span id="vb-toast-msg">Tersimpan</span>
</div>

{{-- Fullscreen Submit Loader --}}
<div id="vb-submit-loader" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.65); z-index: 99999; flex-direction: column; align-items: center; justify-content: center; gap: 14px; backdrop-filter: blur(4px);">
    <div style="width: 44px; height: 44px; border: 3px solid rgba(255,255,255,0.3); border-top-color: #ef4444; border-radius: 50%; animation: vbSpin .8s linear infinite;"></div>
    <div style="font-size: 13px; font-weight: 700; color: #fff; letter-spacing: 1.5px; text-transform: uppercase;">Menyimpan & Mengunggah Konten...</div>
    <div style="font-size: 11px; color: rgba(255,255,255,0.7);">Mohon tunggu beberapa saat, jangan menutup halaman.</div>
</div>

{{-- ============ Summernote ============ --}}
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<script>
const VB = {
    pages: {
        home:    { url: '{{ url('/') }}',                  title: 'Halaman Beranda',    desc: 'Atur konten halaman utama',       label: 'Beranda Utama' },
        profile: { url: '{{ url('/profil-perusahaan') }}', title: 'Profil Perusahaan',  desc: 'Sejarah & lokasi perusahaan',     label: 'Profil Lengkap' },
        vision:  { url: '{{ url('/visi-misi') }}',         title: 'Visi & Misi',        desc: 'Tujuan & strategi perusahaan',    label: 'Visi & Misi' },
        team:    { url: '{{ url('/tim-kami') }}',          title: 'Tim Kami',           desc: 'Struktur organisasi (PDF)',       label: 'Tim Kami' },
        contact: { url: '{{ url('/') }}',                  title: 'Informasi Kontak',   desc: 'Telp, email, alamat & jam',       label: 'Kontak (Footer)' },
        layout:  { url: '{{ url('/') }}',                  title: 'Pengaturan Layout',  desc: 'Toggle visibility section',       label: 'Layout Halaman' }
    },
    currentUrl: '{{ url('/') }}',
    csrf: '{{ csrf_token() }}',

    switchTab(tab) {
        document.querySelectorAll('[id^="vb-tab-"]').forEach(el => el.classList.remove('active'));
        document.getElementById('vb-tab-' + tab).classList.add('active');

        document.querySelectorAll('.vb-panel').forEach(el => el.classList.remove('active'));
        document.getElementById('vb-panel-' + tab).classList.add('active');

        const info = this.pages[tab];
        document.getElementById('vb-section-title').textContent = info.title;
        document.getElementById('vb-section-desc').textContent  = info.desc;
        document.getElementById('vb-page-label').textContent    = info.label;
        document.getElementById('vb-url-display').textContent   = info.url;

        if (info.url !== this.currentUrl) {
            this.currentUrl = info.url;
            document.getElementById('vb-loader').classList.remove('hidden');
            document.getElementById('vb-iframe').src = info.url;
        } else {
            // Auto scroll on same page
            try {
                const iframe = document.getElementById('vb-iframe');
                const doc = iframe.contentDocument || iframe.contentWindow.document;
                if (doc) {
                    if (tab === 'contact') {
                        const target = doc.getElementById('kontak') || doc.querySelector('footer');
                        if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    } else {
                        doc.documentElement.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                }
            } catch (e) { console.warn('Scroll error:', e); }
        }
    },

    togglePanel() {
        document.getElementById('vb-form-panel').classList.toggle('collapsed');
    },

    setDevice(type) {
        const c = document.getElementById('vb-canvas');
        c.classList.remove('tablet', 'mobile');
        if (type !== 'desktop') c.classList.add(type);
        document.querySelectorAll('.vb-device-btn').forEach(b => b.classList.remove('active'));
        document.getElementById('vb-btn-' + type).classList.add('active');
    },

    reloadPreview() {
        document.getElementById('vb-loader').classList.remove('hidden');
        document.getElementById('vb-iframe').contentWindow.location.reload();
    },

    onIframeLoad(iframe) {
        document.getElementById('vb-loader').classList.add('hidden');

        try {
            const doc = iframe.contentDocument || iframe.contentWindow.document;

            // Re-apply current toggle state (in case of reload)
            document.querySelectorAll('input[data-target]').forEach(input => {
                this.applyToggleToIframe(input.dataset.target, input.checked);
            });

            // Inject Figma-mode editable styles
            const style = doc.createElement('style');
            style.innerHTML = `
                .vb-edit { outline: 1px dashed transparent; transition: outline .15s, background .15s; }
                .vb-edit:hover { outline: 2px dashed #ef4444; outline-offset: 4px; background: rgba(239,68,68,.05); cursor: text; border-radius: 4px; }
                .vb-edit:focus { outline: 2px solid #ef4444; outline-offset: 4px; background: rgba(255,255,255,.95); border-radius: 4px; color: #000; }
                .vb-img-edit { transition: outline .15s, filter .15s; }
                .vb-img-edit:hover { outline: 3px dashed #ef4444; outline-offset: 4px; filter: brightness(.88); cursor: pointer; }
                a { pointer-events: none !important; }
            `;
            doc.head.appendChild(style);
            // Editable text fields (home page only)
            if (this.currentUrl === '{{ url('/') }}') {
                const textMaps = [
                    { sel: '.cke-hero__title',     inp: 'in_hero_title' },
                    { sel: '.cke-hero__lead',      inp: 'in_hero_subtitle' },
                    { sel: '#tentang .cke-sh__title', inp: 'in_about_title' },
                    { sel: '#video-kami .cke-sec-hd__title', inp: 'in_video_title' },
                    { sel: '#video-kami .cke-sec-hd__lead',  inp: 'in_video_desc' }
                ];
                textMaps.forEach(m => {
                    const el = doc.querySelector(m.sel);
                    const inp = document.getElementById(m.inp);
                    if (!el || !inp) return;
                    el.classList.add('vb-edit');
                    el.setAttribute('contenteditable', 'true');
                    el.setAttribute('spellcheck', 'false');
                    
                    // Iframe -> Form
                    el.addEventListener('input', () => {
                        if (m.inp === 'in_about_title') {
                            let val = el.innerHTML;
                            val = val.replace(/<em>(.*?)<\/em>/g, '[$1]');
                            val = val.replace(/<[^>]*>/g, '');
                            inp.value = val;
                        } else {
                            inp.value = el.innerText.trim();
                        }
                    });
                });

                const imgMaps = [
                    { sel: '.cke-hero__media', inp: 'in_hero_image' },
                    { sel: '#tentang-img-1', inp: 'in_about_img1' },
                    { sel: '#tentang-img-2', inp: 'in_about_img2' }
                ];
                imgMaps.forEach(m => {
                    const img = doc.querySelector(m.sel);
                    if (!img) return;
                    img.classList.add('vb-img-edit');
                    img.addEventListener('click', e => {
                        e.preventDefault(); e.stopPropagation();
                        document.getElementById(m.inp).click();
                    });
                });
            }

            // Editable text & image upload fields (profile page)
            if (this.currentUrl.includes('/profil-perusahaan')) {
                const profileTextMaps = [
                    { sel: '#profile-gallery .cke-about__badge-num', inp: 'in_profile_badge_num' },
                    { sel: '#profile-gallery .cke-about__badge-lbl', inp: 'in_profile_badge_lbl' }
                ];
                profileTextMaps.forEach(m => {
                    const el = doc.querySelector(m.sel);
                    const inp = document.getElementById(m.inp);
                    if (!el || !inp) return;
                    el.classList.add('vb-edit');
                    el.setAttribute('contenteditable', 'true');
                    el.setAttribute('spellcheck', 'false');
                    
                    el.addEventListener('input', () => {
                        inp.value = el.innerText.trim();
                    });
                });

                const profileImgMaps = [
                    { sel: '#profile-gallery .cke-about__photo--back', inp: 'in_profile_img_main' },
                    { sel: '#profile-gallery .cke-about__photo--front', inp: 'in_profile_img_1' }
                ];
                profileImgMaps.forEach(m => {
                    const img = doc.querySelector(m.sel);
                    if (!img) return;
                    img.classList.add('vb-img-edit');
                    img.addEventListener('click', e => {
                        e.preventDefault(); e.stopPropagation();
                        document.getElementById(m.inp).click();
                    });
                });
            }

            // Bind input to iframe (Form -> Iframe)
            this.bindInputToIframe();

            // Auto scroll on load if on contact tab
            setTimeout(() => {
                const activeTabBtn = document.querySelector('.vb-icon-btn.active');
                if (activeTabBtn) {
                    const tab = activeTabBtn.id.replace('vb-tab-', '');
                    if (tab === 'contact') {
                        const target = doc.getElementById('kontak') || doc.querySelector('footer');
                        if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                }
            }, 300);
        } catch (e) { console.warn('VB iframe access:', e); }
    },

    bindInputToIframe() {
        try {
            const doc = document.getElementById('vb-iframe').contentDocument;
            if (!doc) return;
            
            // Text inputs mapped by ID for Home
            const reverseTextMaps = [
                { inp: 'in_hero_title', sel: '.cke-hero__title' },
                { inp: 'in_hero_subtitle', sel: '.cke-hero__lead' },
                { inp: 'in_about_title', sel: '#tentang .cke-sh__title' },
                { inp: 'in_video_title', sel: '#video-kami .cke-sec-hd__title' },
                { inp: 'in_video_desc', sel: '#video-kami .cke-sec-hd__lead' },
                { inp: 'in_profile_badge_num', sel: '#profile-gallery .cke-about__badge-num' },
                { inp: 'in_profile_badge_lbl', sel: '#profile-gallery .cke-about__badge-lbl' }
            ];
            
            reverseTextMaps.forEach(m => {
                const inp = document.getElementById(m.inp);
                if (inp) {
                    inp.addEventListener('input', () => {
                        const el = doc.querySelector(m.sel);
                        if (el) {
                            if (m.inp === 'in_about_title') {
                                el.innerHTML = inp.value.replace(/\[(.*?)\]/g, '<em>$1</em>');
                            } else {
                                el.innerText = inp.value;
                            }
                        }
                    });
                }
            });

            // Live update for Pills/Tags
            const tagsInp = document.getElementById('in_about_tags');
            if (tagsInp) {
                tagsInp.addEventListener('input', () => {
                    const chipsContainer = doc.querySelector('#tentang .cke-about__chips');
                    if (chipsContainer) {
                        const tags = tagsInp.value.split(',').map(t => t.trim()).filter(t => t.length > 0);
                        chipsContainer.innerHTML = '';
                        tags.forEach((tag, idx) => {
                            const badge = doc.createElement('span');
                            badge.className = 'cke-badge cke-badge--' + (idx % 2 === 0 ? 'brand' : 'green');
                            badge.innerText = tag;
                            chipsContainer.appendChild(badge);
                        });
                    }
                });
            }

            // Live update for Title Color
            const titleColorInp = document.getElementById('in_about_title_color');
            if (titleColorInp) {
                titleColorInp.addEventListener('input', () => {
                    const titleEl = doc.querySelector('#tentang .cke-sh__title');
                    if (titleEl) {
                        titleEl.style.setProperty('color', titleColorInp.value, 'important');
                    }
                });
            }

            // Live update for Highlight Color
            const highlightColorInp = document.getElementById('in_about_title_highlight_color');
            if (highlightColorInp) {
                highlightColorInp.addEventListener('input', () => {
                    const emEl = doc.querySelector('#tentang .cke-sh__title em');
                    if (emEl) {
                        emEl.style.setProperty('color', highlightColorInp.value, 'important');
                    }
                });
            }

            // Live update for Badge Background Color
            const badgeBgColorInp = document.getElementById('in_profile_badge_bg_color');
            if (badgeBgColorInp) {
                badgeBgColorInp.addEventListener('input', () => {
                    const badgeEl = doc.querySelector('#profile-gallery .cke-about__badge');
                    if (badgeEl) {
                        badgeEl.style.setProperty('background-color', badgeBgColorInp.value, 'important');
                    }
                });
            }

            // Live update for Badge Text/Number Color
            const badgeTextColorInp = document.getElementById('in_profile_badge_text_color');
            if (badgeTextColorInp) {
                badgeTextColorInp.addEventListener('input', () => {
                    const numEl = doc.querySelector('#profile-gallery .cke-about__badge-num');
                    if (numEl) {
                        numEl.style.setProperty('color', badgeTextColorInp.value, 'important');
                    }
                });
            }

            // Contact inputs mapped by data-target-sel
            document.querySelectorAll('input[data-target-sel], textarea[data-target-sel]').forEach(inp => {
                // Jangan target summernote lewat sini
                if(inp.classList.contains('summernote')) return; 

                inp.addEventListener('input', () => {
                    const elements = doc.querySelectorAll(inp.getAttribute('data-target-sel'));
                    elements.forEach(el => {
                        el.innerText = inp.value;
                    });
                    
                    // Khusus email sekunder, sembunyikan container jika kosong
                    if (inp.id === 'in_contact_email_2') {
                        const wrapEl = doc.getElementById('vb-contact-email2-wrap');
                        if (wrapEl) {
                            wrapEl.style.display = inp.value.trim().length > 0 ? '' : 'none';
                        }
                    }
                });
            });
        } catch (e) { console.warn('Bind input to iframe error', e); }
    },

    /* ============== TOGGLE LIVE + AUTO-SAVE ============== */
    handleToggle(input) {
        const key = input.dataset.key;
        const target = input.dataset.target;
        const isOn = input.checked;

        // Visual feedback on the row
        document.getElementById('row_' + key).classList.toggle('off', !isOn);

        // Apply to iframe instantly
        this.applyToggleToIframe(target, isOn);

        // Auto-save via AJAX
        this.saveToggle(key, isOn);
    },

    applyToggleToIframe(targetSelector, show) {
        try {
            const doc = document.getElementById('vb-iframe').contentDocument;
            if (!doc) return;
            const el = doc.querySelector(targetSelector);
            if (!el) return;
            if (show) {
                el.style.display = '';
                el.style.opacity = '1';
                el.style.transition = 'opacity .3s';
            } else {
                el.style.transition = 'opacity .2s';
                el.style.opacity = '0';
                setTimeout(() => { el.style.display = 'none'; }, 200);
            }
        } catch (e) { console.warn('VB iframe toggle:', e); }
    },

    saveToggle(key, isOn) {
        const fd = new FormData();
        fd.append('_token', this.csrf);
        fd.append('_method', 'PUT');
        fd.append('_partial', '1');
        if (isOn) fd.append(key, '1');
        // Send ALL current toggles so backend knows the state (unchecked = absent = 0)
        document.querySelectorAll('input[data-key]').forEach(i => {
            if (i.dataset.key !== key && i.checked) fd.append(i.dataset.key, '1');
        });

        fetch('{{ route('admin.page_settings.update') }}', {
            method: 'POST',
            body: fd,
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        }).then(r => {
            this.toast(isOn ? 'Section ditampilkan' : 'Section disembunyikan', 'success');
        }).catch(err => {
            this.toast('Gagal menyimpan', 'error');
            console.error(err);
        });
    },

    previewLocalImage(input, selector, fnameId) {
        if (!input.files || !input.files[0]) return;

        // Limit local image selection to 3MB
        if (input.files[0].size > 3 * 1024 * 1024) {
            alert('Ukuran file gambar terlalu besar. Maksimal 3MB.');
            input.value = ''; // Reset input
            if (fnameId) document.getElementById(fnameId).textContent = '';
            return;
        }

        if (fnameId) document.getElementById(fnameId).textContent = '✓ ' + input.files[0].name;
        const reader = new FileReader();
        reader.onload = e => {
            try {
                const doc = document.getElementById('vb-iframe').contentDocument;
                const img = doc.querySelector(selector);
                if (img) {
                    if (img.tagName.toLowerCase() === 'img') {
                        img.src = e.target.result;
                    } else {
                        img.style.backgroundImage = `url('${e.target.result}')`;
                    }
                }
            } catch (err) {}
        };
        reader.readAsDataURL(input.files[0]);
    },

    toast(msg, type = 'success') {
        const el = document.getElementById('vb-toast');
        const icon = document.getElementById('vb-toast-icon');
        document.getElementById('vb-toast-msg').textContent = msg;
        el.classList.remove('success', 'error');
        el.classList.add(type);
        icon.textContent = type === 'success' ? 'check_circle' : 'error';
        el.classList.add('show');
        clearTimeout(this._toastT);
        this._toastT = setTimeout(() => el.classList.remove('show'), 2200);
    }
};

// Filename displays & File size validation
document.getElementById('in_pdf_file').addEventListener('change', function() {
    if (this.files && this.files[0]) {
        // Limit PDF to 10MB
        if (this.files[0].size > 10 * 1024 * 1024) {
            alert('Ukuran file PDF terlalu besar. Maksimal 10MB.');
            this.value = ''; // Reset
            document.getElementById('fn_pdf').textContent = '';
            return;
        }
        document.getElementById('fn_pdf').textContent = '✓ ' + this.files[0].name;
    }
});

document.getElementById('in_video_file').addEventListener('change', function() {
    if (this.files && this.files[0]) {
        // Limit Video to 20MB
        if (this.files[0].size > 20 * 1024 * 1024) {
            alert('Ukuran file video terlalu besar. Maksimal 20MB.');
            this.value = ''; // Reset
            document.getElementById('fn_video').textContent = '';
            return;
        }
        document.getElementById('fn_video').textContent = '✓ ' + this.files[0].name;
    }
});

// Fullscreen submit loader on publish
document.getElementById('vb-form').addEventListener('submit', function() {
    document.getElementById('vb-submit-loader').style.display = 'flex';
});

// Keep Laravel session alive (heartbeat) every 5 minutes to prevent CSRF expiration (419 Page Expired)
setInterval(() => {
    fetch('{{ route('admin.dashboard') }}', {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    }).catch(e => console.log('Session ping failed', e));
}, 5 * 60 * 1000);

// Summernote
$(document).ready(function() {
    $('.summernote').summernote({
        placeholder: 'Tulis konten di sini...',
        tabsize: 2,
        height: 180,
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['link', 'picture']]
        ],
        callbacks: {
            onImageUpload: function(files) { uploadImage(files[0], $(this)); },
            onChange: function(contents, $editable) {
                // Sinkronkan ke iframe jika ada target
                var targetSel = $(this).attr('data-target-sel');
                if (targetSel) {
                    try {
                        const doc = document.getElementById('vb-iframe').contentDocument;
                        if (doc) {
                            const el = doc.querySelector(targetSel);
                            if (el) el.innerHTML = contents;
                        }
                    } catch(e) {}
                }
            }
        }
    });

    // Show success toast on full save redirect
    @if(session('success'))
        VB.toast('{{ session('success') }}', 'success');
    @endif
});

function uploadImage(file, editor) {
    // Limit Summernote inline image uploads to 2MB
    if (file.size > 2 * 1024 * 1024) {
        alert('Ukuran file gambar terlalu besar. Maksimal 2MB.');
        return;
    }
    var data = new FormData();
    data.append("file", file);
    data.append("_token", "{{ csrf_token() }}");
    $.ajax({
        url: "{{ route('admin.page_settings.upload_image') }}",
        cache: false, contentType: false, processData: false, type: 'POST',
        success: r => editor.summernote('insertImage', r.location),
        error: () => alert('Gagal upload gambar.')
    });
}
</script>
@endsection
