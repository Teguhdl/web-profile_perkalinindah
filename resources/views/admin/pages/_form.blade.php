{{-- Form fragment: dipakai di create + edit --}}
<style>
    @media (min-width: 1024px) {
        .custom-form-layout {
            display: grid;
            grid-template-columns: minmax(0, 2fr) minmax(0, 1fr);
            gap: 1.5rem;
        }
    }
    @media (max-width: 1023px) {
        .custom-form-layout {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }
    }
</style>
<div class="custom-form-layout">
    {{-- KIRI: Konten utama --}}
    <div class="space-y-6">
        <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm">
            <div class="mb-5">
                <label class="block text-base font-bold text-gray-900 mb-2">Judul Halaman <span class="text-red-500">*</span></label>
                <p class="text-xs text-gray-500 mb-3">Judul utama yang akan ditampilkan di paling atas halaman.</p>
                <input type="text" name="label" value="{{ old('label', $page->label ?? '') }}" required
                       class="w-full border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-red-200 focus:border-red-500 text-lg font-bold text-black"
                       placeholder="Contoh: Produk Kami">
                @error('label') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
            
            <div>
                <label class="block text-base font-bold text-gray-900 mb-2">Subjudul / Deskripsi Singkat</label>
                <p class="text-xs text-gray-500 mb-3">Teks kecil berwarna abu-abu yang muncul di bawah judul utama.</p>
                <input type="text" name="hero_subtitle" value="{{ old('hero_subtitle', $page->hero_subtitle ?? '') }}"
                       class="w-full border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-red-200 focus:border-red-500 text-gray-700" 
                       placeholder="Contoh: Temukan Produk yang ingin dicari!">
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm">
            <label class="block text-base font-bold text-gray-900 mb-2">Isi Konten Halaman</label>
            <p class="text-xs text-gray-500 mb-4">Tulis informasi, masukkan gambar, tabel, atau video di sini. Gunakan tombol <span class="bg-gray-100 px-2 py-0.5 rounded border font-medium">📁 Media</span> untuk memasukkan gambar yang sudah di-upload.</p>
            <textarea name="content" id="content-editor" rows="20">{{ old('content', $page->content ?? '') }}</textarea>
        </div>


    </div>

    {{-- KANAN: Settings --}}
    <div class="space-y-6">
        {{-- Pengaturan Dasar --}}
        <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm">
            <h3 class="font-bold text-gray-900 mb-4 border-b pb-2 flex items-center gap-2">
                <span class="material-symbols-outlined text-red-600">settings</span> Pengaturan Dasar
            </h3>

            <div class="space-y-4">
                {{-- Status Publikasi --}}
                <label class="flex items-start gap-3 p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                    <input type="checkbox" name="is_published" value="1" {{ old('is_published', $page->is_published ?? true) ? 'checked' : '' }} class="w-5 h-5 mt-0.5 text-red-600 rounded">
                    <div>
                        <div class="font-semibold text-sm text-gray-900">Publikasikan Halaman</div>
                        <div class="text-xs text-gray-500">Jika dicentang, halaman bisa diakses pengunjung.</div>
                    </div>
                </label>

                {{-- Tampil di Menu --}}
                <label class="flex items-start gap-3 p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                    <input type="checkbox" name="show_in_menu" value="1" {{ old('show_in_menu', $page->show_in_menu ?? true) ? 'checked' : '' }} class="w-5 h-5 mt-0.5 text-red-600 rounded">
                    <div>
                        <div class="font-semibold text-sm text-gray-900">Tampilkan di Menu Navigasi</div>
                        <div class="text-xs text-gray-500">Muncul di menu atas website.</div>
                    </div>
                </label>

                {{-- URL / Link --}}
                <div class="pt-2">
                    <label class="block text-sm font-semibold text-gray-900 mb-1">Alamat Link Halaman</label>
                    <p class="text-xs text-gray-500 mb-2">Alamat URL untuk mengakses halaman ini.</p>
                    <div class="flex items-center bg-gray-50 border border-gray-300 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-red-200 focus-within:border-red-500">
                        <span class="text-xs text-gray-400 px-3 py-2 bg-gray-100 border-r whitespace-nowrap select-none shrink-0">domain.com/</span>
                        <input type="text" name="slug" id="slug-input" value="{{ old('slug', $page->slug ?? '') }}" required
                               {{ (isset($page) && $page->slug === '/') ? 'readonly' : '' }}
                               class="flex-1 min-w-0 px-3 py-2 text-sm border-none bg-transparent focus:ring-0 font-mono"
                               placeholder="contoh-halaman">
                    </div>
                    <p class="text-[10px] text-gray-400 mt-1">Diisi otomatis dari judul. Hanya huruf kecil, angka & tanda hubung.</p>
                    @error('slug') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Hirarki Menu --}}
                <div class="pt-2">
                    <label class="block text-sm font-semibold text-gray-900 mb-1">Posisi Menu</label>
                    <select name="parent_id" class="w-full border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-red-200 focus:border-red-500">
                        <option value="0">Sebagai Menu Utama</option>
                        @foreach($parents as $p)
                            <option value="{{ $p->id }}" {{ old('parent_id', $page->parent_id ?? 0) == $p->id ? 'selected' : '' }}>↳ Sub-menu dari: {{ $p->label }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Urutan --}}
                <div class="pt-2">
                    <label class="block text-sm font-semibold text-gray-900 mb-1">Urutan Tampil</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $page->sort_order ?? 999) }}"
                           class="w-full border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-red-200 focus:border-red-500" placeholder="Contoh: 1">
                </div>
            </div>
        </div>

        {{-- SEO (Google & Sosmed) --}}
        <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm">
            <h3 class="font-bold text-gray-900 mb-4 border-b pb-2 flex items-center gap-2">
                <span class="material-symbols-outlined text-blue-600">travel_explore</span> Optimasi SEO & Sosmed
            </h3>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-1">Judul di Pencarian Google</label>
                    <input type="text" name="meta_title" value="{{ old('meta_title', $page->meta_title ?? '') }}"
                           maxlength="60" class="w-full border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-200 focus:border-blue-500"
                           placeholder="Bisa dikosongkan (otomatis ikut Judul Halaman)">
                    <p class="text-[10px] text-gray-500 mt-1">Maksimal 60 karakter.</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-1">Deskripsi Singkat (Google)</label>
                    <textarea name="meta_description" rows="3" maxlength="160"
                              class="w-full border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-200 focus:border-blue-500"
                              placeholder="Penjelasan singkat halaman (muncul di hasil pencarian Google)">{{ old('meta_description', $page->meta_description ?? '') }}</textarea>
                    <p class="text-[10px] text-gray-500 mt-1">Maksimal 160 karakter.</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-1">Kata Kunci (Keywords)</label>
                    <input type="text" name="meta_keywords" value="{{ old('meta_keywords', $page->meta_keywords ?? '') }}"
                           class="w-full border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-200 focus:border-blue-500"
                           placeholder="contoh: jual karet, pabrik karet subang">
                </div>

                <div class="bg-blue-50 p-3 rounded-lg border border-blue-100">
                    <label class="block text-sm font-semibold text-blue-900 mb-1">Gambar Preview (WhatsApp/Facebook)</label>
                    <p class="text-[10px] text-blue-700 mb-2">Gambar yang muncul saat link halaman dibagikan.</p>
                    @if(isset($page) && $page->og_image)
                        <img src="{{ asset($page->og_image) }}" class="w-full h-24 object-cover rounded border border-blue-200 mb-2">
                    @endif
                    <input type="file" name="og_image" accept="image/*"
                           class="w-full text-xs text-gray-700 file:mr-3 file:py-1 file:px-3 file:rounded file:border-0 file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-6 flex justify-between">
    <a href="{{ route('admin.pages.index') }}" class="px-5 py-2.5 text-gray-600 hover:bg-gray-50 rounded-lg">← Kembali</a>
    <button type="submit" class="bg-red-600 text-white px-8 py-2.5 rounded-lg font-bold hover:bg-red-700 transition flex items-center gap-2">
        <span class="material-symbols-outlined">save</span>
        Simpan Halaman
    </button>
</div>

{{-- ============ TinyMCE ============ --}}
{{-- OFFLINE MODE: File diambil dari folder public/vendor/tinymce --}}
<script src="{{ asset('vendor/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
<script>
window.PageEditorConfig = {
    mediaJsonUrl: "{{ route('admin.media.json') }}",
    mediaUploadUrl: "{{ route('admin.media.upload') }}",
    csrf: "{{ csrf_token() }}"
};

tinymce.init({
    selector: 'textarea#content-editor',
    promotion: false,
    branding: false,
    license_key: 'gpl',
    height: 700,
    
    // PENTING: Jangan convert URL gambar menjadi ../../ 
    relative_urls: false,
    remove_script_host: false,
    document_base_url: "{{ url('/') }}/",
    
    menubar: 'edit view insert format table',
    plugins: 'advlist autolink lists link image charmap preview anchor pagebreak searchreplace wordcount visualblocks code fullscreen insertdatetime media table emoticons help',
    
    // TAMPILKAN SEMUA TOOLBAR, JANGAN DISEMBUNYIKAN
    toolbar_mode: 'wrap',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image mediaLibrary table | removeformat | code preview fullscreen',
    
    image_caption: true,
    image_title: true,
    image_advtab: true,
    automatic_uploads: true,
    file_picker_types: 'image media',
    images_upload_url: PageEditorConfig.mediaUploadUrl,
    images_upload_credentials: true,
    images_upload_handler: function (blobInfo, progress) {
        return new Promise((resolve, reject) => {
            const formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());
            formData.append('_token', PageEditorConfig.csrf);
            fetch(PageEditorConfig.mediaUploadUrl, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': PageEditorConfig.csrf, 'Accept': 'application/json' },
                body: formData
            })
            .then(r => r.json())
            .then(d => { d.location ? resolve(d.location) : reject('Upload gagal'); })
            .catch(err => reject(err.message || 'Upload gagal'));
        });
    },
    file_picker_callback: function (cb, value, meta) {
        if (meta.filetype === 'image') {
            const w = window.open(
                "{{ route('admin.media.browser') }}?picker=1",
                "MediaLibrary",
                "width=900,height=600"
            );
            window._tinymceCb = cb;
        }
    },
    setup: function (editor) {
        // Auto Update live preview
        editor.on('input change blur', function() {
            if (typeof updatePreview === 'function') {
                updatePreview();
            }
        });
        
        // Add MediaLibrary button logic
        editor.ui.registry.addButton('mediaLibrary', {
            text: '📁 Media',
            tooltip: 'Pilih & Upload dari Media Library',
            onAction: function () {
                // Gunakan iframe popup bawaan TinyMCE
                editor.windowManager.openUrl({
                    title: 'Media Library',
                    url: "{{ route('admin.media.browser') }}?picker=1",
                    width: 900,
                    height: 600,
                    onMessage: function(api, data) {
                        if (data.mceAction === 'insertImage') {
                            editor.insertContent(`<img src="${data.url}" alt="${data.alt}" loading="lazy" style="max-width:100%;height:auto;border-radius:8px;">`);
                            api.close();
                        }
                    }
                });
            }
        });
    },
    content_style: 'body{font-family:Inter,sans-serif;font-size:15px;line-height:1.6;color:#333} h1,h2,h3{font-weight:700} img{max-width:100%;height:auto;border-radius:8px;}'
});
</script>
