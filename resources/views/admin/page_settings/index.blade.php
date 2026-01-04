@extends('admin.layouts.app')

@section('title', 'Kelola Halaman')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900">Kelola Konten Halaman</h1>
    <p class="text-gray-500 text-sm">Edit konten untuk Profil Perusahaan, Visi Misi, dan Tentang Kami.</p>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="border-b border-gray-100">
        <nav class="flex -mb-px" aria-label="Tabs" id="tabs">
            <button onclick="switchTab('profile')" id="tab-profile" class="tab-btn w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                Profil Perusahaan
            </button>
            <button onclick="switchTab('visi-misi')" id="tab-visi-misi" class="tab-btn w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                Visi & Misi
            </button>
            <button onclick="switchTab('about')" id="tab-about" class="tab-btn w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                Halaman Dashboard
            </button>
            <button onclick="switchTab('team')" id="tab-team" class="tab-btn w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                Tim Kami (PDF)
            </button>

        </nav>
    </div>

    <form action="{{ route('admin.page_settings.update') }}" method="POST" enctype="multipart/form-data" class="p-6">
        @csrf
        @method('PUT')
        
        <!-- PROFIL PERUSAHAAN -->
        <div id="content-profile" class="tab-content hidden">
            <h3 class="text-lg font-bold text-gray-900 mb-6">Profil Perusahaan</h3>
            
            
            <div class="max-w-4xl mx-auto mb-16">
                {{-- Visual Wrapper mimicking Frontend (Top Card) --}}
                <div class="relative pt-4 pl-4">
                    <div class="relative">
                        <div class="absolute -bottom-5 -left-5 w-full h-full bg-[#FF0000] rounded-[30px]"></div>
                        <div class="relative bg-white border border-gray-100 rounded-[30px] p-8 shadow-sm z-10">
                             <h4 class="font-bold text-gray-700 mb-2">Intro / Sejarah</h4>
                            <textarea name="page_company_profile_content" class="summernote">{{ $settings['page_company_profile_content'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="max-w-4xl mx-auto">
                 {{-- Visual Wrapper mimicking Frontend (Bottom Card - Sertifikasi) --}}
                <div class="relative pt-4 pr-4">
                     <div class="relative">
                        <div class="absolute -bottom-4 -right-4 w-full h-full bg-[#FF9F9F] rounded-[40px]"></div>
                        <div class="relative bg-white border border-gray-200 rounded-[40px] p-8 z-10">
                            <h4 class="font-bold text-gray-700 mb-2">Sertifikasi & Lokasi</h4>
                            <textarea name="page_profile_cert_content" class="summernote">{{ $settings['page_profile_cert_content'] ?? '' }}</textarea>
                        </div>
                     </div>
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-10 text-center">Tampilan di atas menyerupai desain di halaman website.</p>
        </div>

        <!-- VISI MISI -->
        <div id="content-visi-misi" class="tab-content hidden">
            <h3 class="text-lg font-bold text-gray-900 mb-6">Visi & Misi</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-6xl mx-auto">
                
                {{-- VISI CARD --}}
                <div class="bg-white rounded-[30px] border-[3px] border-red-600 p-8 shadow-[0_10px_30px_rgba(255,0,0,0.15)] flex flex-col">
                    <h2 class="text-3xl font-extrabold text-black mb-4 relative inline-block text-center w-full">
                        VISI
                        <span class="block w-24 h-[2px] bg-gray-200 mt-2 mx-auto"></span>
                    </h2>
                    
                    <div class="flex-1">
                        <textarea name="page_visi_content" class="summernote">{{ $settings['page_visi_content'] ?? '' }}</textarea>
                    </div>
                </div>

                {{-- MISI CARD --}}
                <div class="bg-white rounded-[30px] border border-gray-200 p-8 shadow-lg">
                    <div class="text-center mb-4">
                        <h2 class="text-3xl font-extrabold text-black relative inline-block">
                            MISI
                            <span class="block w-24 h-[2px] bg-gray-200 mt-2 mx-auto"></span>
                        </h2>
                    </div>

                    <div>
                        <textarea name="page_misi_content" class="summernote">{{ $settings['page_misi_content'] ?? '' }}</textarea>
                    </div>
                </div>

            </div>
             <p class="text-xs text-gray-400 mt-10 text-center">Tampilan editor disesuaikan dengan kartu Visi & Misi di website.</p>
        </div>

        <!-- DASHBOARD -->
        <div id="content-about" class="tab-content hidden">
            <h3 class="text-lg font-bold text-gray-900 mb-6">Halaman Dashboard</h3>
            
            <!-- HERO SECTION -->
            <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 mb-8">
                <h4 class="font-bold text-gray-800 mb-4 border-b pb-2">Hero Section (Atas)</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Utama</label>
                        <input type="text" name="dashboard_hero_title" value="{{ $settings['dashboard_hero_title'] ?? '' }}" class="w-full bg-white border-gray-300 rounded-lg px-4 py-2" placeholder="PT. PERKALIN INDAH">
                    </div>
                     <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Sub Judul</label>
                        <input type="text" name="dashboard_hero_subtitle" value="{{ $settings['dashboard_hero_subtitle'] ?? '' }}" class="w-full bg-white border-gray-300 rounded-lg px-4 py-2" placeholder="Provider Solution Rubber...">
                    </div>
                </div>
            </div>

            <!-- ABOUT SECTION -->
            <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 mb-8">
                 <h4 class="font-bold text-gray-800 mb-4 border-b pb-2">Section Tentang Kami</h4>
                 
                 <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Konten Deskripsi</label>
                    <textarea name="page_about_content" class="summernote">{{ $settings['page_about_content'] ?? '' }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                     <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar 1 (Kecil - Depan)</label>
                         @if(isset($settings['dashboard_about_image_1']))
                            <div class="mb-2">
                                <img src="{{ asset($settings['dashboard_about_image_1']) }}" class="h-24 rounded shadow">
                            </div>
                        @endif
                        <input type="file" name="dashboard_about_image_1" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar 2 (Besar - Belakang)</label>
                         @if(isset($settings['dashboard_about_image_2']))
                            <div class="mb-2">
                                <img src="{{ asset($settings['dashboard_about_image_2']) }}" class="h-24 rounded shadow">
                            </div>
                        @endif
                        <input type="file" name="dashboard_about_image_2" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                    </div>
                </div>
            </div>

             <!-- VIDEO SECTION -->
             <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
                 <h4 class="font-bold text-gray-800 mb-4 border-b pb-2">Section Video Profile</h4>
                 <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Video</label>
                        <input type="text" name="dashboard_video_title" value="{{ $settings['dashboard_video_title'] ?? '' }}" class="w-full bg-white border-gray-300 rounded-lg px-4 py-2" placeholder="Video Kami">
                    </div>
                     <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Singkat</label>
                         <input type="text" name="dashboard_video_desc" value="{{ $settings['dashboard_video_desc'] ?? '' }}" class="w-full bg-white border-gray-300 rounded-lg px-4 py-2" placeholder="Sekilas mengenai...">
                    </div>
                </div>
                
                 <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Upload File Video (MP4)</label>
                         @if(isset($settings['dashboard_video_url']))
                            <div class="mb-2 text-sm text-green-600">
                                Video saat ini: <a href="{{ asset($settings['dashboard_video_url']) }}" target="_blank" class="underline">Lihat Video</a>
                            </div>
                        @endif
                        <input type="file" name="dashboard_video_url" accept="video/mp4" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                 </div>
             </div>
        </div>

        <!-- TIM KAMI -->
        <div id="content-team" class="tab-content hidden">
            <h3 class="text-lg font-bold text-gray-900 mb-6">Tim Kami (Struktur Organisasi)</h3>
            
            <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 text-center">
                <div class="mb-4">
                    <span class="material-symbols-outlined text-4xl text-red-600 mb-2">picture_as_pdf</span>
                    <p class="text-sm text-gray-600">Upload file PDF Struktur Organisasi terbaru.</p>
                </div>

                @php
                    $currentPdf = \App\Models\Setting::where('key', 'page_team_pdf')->value('value');
                @endphp

                @if($currentPdf)
                    <div class="mb-6 p-4 bg-white rounded-lg border border-gray-200 inline-block">
                        <p class="text-sm text-green-600 font-semibold mb-2">File saat ini:</p>
                        <a href="{{ asset($currentPdf) }}" target="_blank" class="text-red-600 underline hover:text-red-800 flex items-center gap-2 justify-center">
                            <span class="material-symbols-outlined text-sm">visibility</span>
                            Lihat PDF
                        </a>
                    </div>
                @endif

                <div class="max-w-md mx-auto">
                    <label class="block mb-2 text-sm font-medium text-gray-900" for="file_input">Upload file baru</label>
                    <input name="page_team_pdf" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" id="file_input" type="file" accept="application/pdf">
                    <p class="mt-1 text-xs text-gray-500">PDF (MAX. 5MB).</p>
                </div>
            </div>
        </div>



        <div class="mt-6 flex justify-end">
            <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-red-700 transition">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<!-- Load Summernote CSS/JS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<script>
    $(document).ready(function() {
        $('.summernote').summernote({
            placeholder: 'Tulis konten disini...',
            tabsize: 2,
            height: 200, // Slightly smaller to fit in cards
            toolbar: [
                ['style', ['style', 'bold', 'italic', 'underline', 'clear']],
                ['font', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture']],
                ['view', ['codeview']]
            ],
            callbacks: {
                onImageUpload: function(files) {
                    uploadImage(files[0], $(this));
                }
            }
        });

        // Initialize default tab
        switchTab('profile');
    });

    function uploadImage(file, editor) {
        var data = new FormData();
        data.append("file", file);
        data.append("_token", "{{ csrf_token() }}");
        $.ajax({
            url: "{{ route('admin.page_settings.upload_image') }}",
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function(response) {
                editor.summernote('insertImage', response.location);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error(textStatus + " " + errorThrown);
                alert('Gagal mengupload gambar.');
            }
        });
    }

    function switchTab(tabName) {
        // Hide all contents
        document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
        // Show selected content
        document.getElementById('content-' + tabName).classList.remove('hidden');

        // Reset tab styles
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('border-red-500', 'text-red-600');
            btn.classList.add('border-transparent', 'text-gray-500');
        });

        // Highlight selected tab
        const activeBtn = document.getElementById('tab-' + tabName);
        activeBtn.classList.remove('border-transparent', 'text-gray-500');
        activeBtn.classList.add('border-red-500', 'text-red-600');
    }
</script>
@endsection
