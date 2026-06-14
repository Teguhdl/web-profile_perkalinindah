<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Traits\UploadsWebP;

class PageSettingController extends Controller
{
    use UploadsWebP;
    public function index()
    {
        $settingsArray = Setting::whereIn('key', [
            'page_company_profile_content',
            'page_profile_cert_content',
            'page_visi_content',
            'page_misi_content',
            'page_about_content',
            // Dashboard Specific
            'dashboard_hero_title',
            'dashboard_hero_subtitle',
            'dashboard_hero_image',
            'dashboard_about_image_1',
            'dashboard_about_image_2',
            'dashboard_video_title',
            'dashboard_video_desc',
            'dashboard_video_url', // or file
            // Contact Settings
            'contact_phone',
            'contact_email_1',
            'contact_email_2',
            'contact_address',
            'contact_maps_link',
            'contact_hours_mon_fri',
            'contact_hours_sat',
            // Dashboard Section Toggle
            'dashboard_show_hero',
            'dashboard_show_about',
            'dashboard_show_video',
            'dashboard_show_products',
            'dashboard_show_mitra',
            // Profile Page Images
            'profile_image_main',
            'profile_image_1',
            'profile_image_2',
            'profile_image_3',
            'profile_cert_image',
            'profile_show_gallery',
            'profile_badge_number',
            'profile_badge_label',
            'profile_badge_bg_color',
            'profile_badge_text_color',
            'dashboard_about_title',
            'dashboard_about_tags',
            'dashboard_about_title_color',
            'dashboard_about_title_highlight_color',
        ])->pluck('value', 'key')->toArray();

        $defaultSettings = [
            'dashboard_hero_title' => 'PT. PERKALIN INDAH',
            'dashboard_hero_subtitle' => 'Provider Solution Rubber and Metal Part',
            'dashboard_video_title' => 'Video Kami',
            'dashboard_video_desc' => 'Sekilas mengenai proses produksi dan komitmen PT. Perkalin Indah.',
            'dashboard_about_title' => 'Mitra terpercaya untuk [produk karet & logam] Anda',
            'dashboard_about_tags' => 'Rubber Part, Polyurethane, Metal Sparepart, Industrial Plastic, Standar K3',
            'dashboard_about_title_color' => '#0f172a',
            'dashboard_about_title_highlight_color' => '#dc2626',
            'profile_badge_number' => '1973',
            'profile_badge_label' => 'Tahun Berdiri',
            'profile_badge_bg_color' => '#0f172a',
            'profile_badge_text_color' => '#b6d335',
            
            'page_about_content' => '<p><strong>PT. Perkalin Indah</strong> didirikan pada tahun 1973 dan bergerak di bidang industri berbagai jenis barang yang terbuat dari karet, polyurethane, logam, dan plastik.</p><p>Perkembangan teknologi yang semakin pesat telah mendorong perusahaan-perusahaan industri, termasuk PT Perkalin Indah, untuk terus meningkatkan efektivitas dan efisiensi dalam operasional bisnisnya.</p><p>PT Perkalin Indah berkomitmen to senantiasa memberi prioritas kepada klien, bekerja secara profesional, berintegritas, efektif, dan efisien, serta memperhatikan standar K3 (Keselamatan, Kesehatan, Kerja). Komitmen ini dijalankan guna memenuhi ekspektasi klien atas setiap karya yang kami hasilkan.</p>',
            
            'page_company_profile_content' => '<p>PT. PERKALIN INDAH didirikan tahun 1973 yang bergerak di bidang industri berbagai jenis barang-barang yang terbuat dari karet, polyurethane, logam dan plastik.</p><p>PT Perkalin Indah berkomitmen untuk senantiasa memberi prioritas pada klien, bekerja secara profesional, berintegritas, efektif, efisien serta memperhatikan standar K3 dari lingkungan kerja.</p>',
            
            'page_visi_content' => '<p>Menjadi <span style="color: rgb(220, 38, 38);"><strong>one stops solution</strong></span> bagi perusahaan manufaktur yang kompetitif, berkualitas, berkompetensi, handal, inovatif dan berdaya saing serta mampu berkembang <span style="color: rgb(220, 38, 38);"><strong>sehat</strong></span> dan <span style="color: rgb(220, 38, 38);"><strong>mandiri</strong></span>.</p>',
            
            'page_misi_content' => '<ul><li>Menjadi perusahaan yang memiliki produk yang <strong>berkembang</strong> dan <strong>bervariasi</strong> sesuai dengan kebutuhan dan permintaan konsumen.</li><li>Menjadi perusahaan yang memiliki daya saing dengan memberikan <strong>harga terbaik</strong> dengan <strong>kualitas terbaik</strong>.</li><li>Mengutamakan mutu, keselamatan kerja, dan keandalan pelayanan untuk <strong>kepuasan pelanggan</strong> dan mitra kerja.</li><li>Proses pengiriman yang <strong>cepat</strong> dan <strong>efisien</strong> bagi partner.</li><li>Menciptakan peluang dan nilai tambah bagi stakeholder melalui <strong>inovasi</strong> dan <strong>teknologi</strong>.</li><li>Membangun <strong>sumber daya manusia unggul</strong> untuk berprestasi, berkreasi, dan tumbuh bersama berlandaskan nilai-nilai budaya PT Perkalin Indah.</li></ul>',
            
            'contact_phone' => '(0260) 4641643',
            'contact_email_1' => 'marketing@perkaliindah.com',
            'contact_address' => 'Jl. Cibeuying, Wantilan, Subang, Kabupaten Subang, Jawa Barat 41272',
            'contact_hours_mon_fri' => '8:00 AM – 6:00 PM',
            'contact_hours_sat' => '9:00 AM – 2:00 PM',
        ];

        // Merge manual: gunakan default jika value di database kosong (null / empty string)
        $settings = [];
        foreach ($defaultSettings as $key => $val) {
            $dbVal = $settingsArray[$key] ?? null;
            $settings[$key] = (!empty($dbVal)) ? $dbVal : $val;
        }
        foreach ($settingsArray as $key => $val) {
            if (!isset($settings[$key])) {
                $settings[$key] = $val;
            }
        }

        return view('admin.page_settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $toggleKeys = [
            'dashboard_show_hero',
            'dashboard_show_about',
            'dashboard_show_video',
            'dashboard_show_products',
            'dashboard_show_mitra',
            'profile_show_gallery',
        ];

        // ============== PARTIAL SAVE (AJAX toggle on/off) ==============
        // Hanya menyimpan toggle keys tanpa menyentuh data lain
        if ($request->boolean('_partial')) {
            foreach ($toggleKeys as $tk) {
                Setting::updateOrCreate(
                    ['key' => $tk],
                    ['value' => $request->has($tk) ? '1' : '0', 'type' => 'text']
                );
            }
            \Illuminate\Support\Facades\Cache::forget('sitemap.xml');

            // Log lightweight activity (optional, skip jika spammy)
            return response()->json([
                'success' => true,
                'message' => 'Pengaturan layout diperbarui',
                'toggles' => collect($toggleKeys)->mapWithKeys(fn($k) => [$k => $request->has($k) ? '1' : '0'])
            ]);
        }

        // ============== FULL SAVE ==============
        $data = $request->except([
            '_token', 
            '_method', 
            '_partial',
            'page_team_pdf',
            'dashboard_hero_image',
            'dashboard_about_image_1',
            'dashboard_about_image_2',
            'dashboard_video_url',
            'profile_image_main',
            'profile_image_1',
            'profile_image_2',
            'profile_image_3',
            'profile_cert_image',
        ]);

        // Handle Dashboard Section Toggles (checkbox) — kalau unchecked, request tidak mengirim → simpan 0
        foreach ($toggleKeys as $tk) {
            $data[$tk] = $request->has($tk) ? '1' : '0';
        }

        // Bersihkan sitemap cache karena perubahan dashboard mempengaruhi homepage
        \Illuminate\Support\Facades\Cache::forget('sitemap.xml');

        // Handle Text Settings
        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'type' => 'text']
            );
        }

        // Handle PDF Upload
        if ($request->hasFile('page_team_pdf')) {
            $file = $request->file('page_team_pdf');
            $filename = 'struktur_organisasi_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('uploads/pdf', $filename, 'public');
            
            // Delete old PDF if exists
            $oldPdf = Setting::where('key', 'page_team_pdf')->value('value');
            if ($oldPdf && Storage::disk('public')->exists(str_replace('storage/', '', $oldPdf))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $oldPdf));
            }

            Setting::updateOrCreate(
                ['key' => 'page_team_pdf'],
                ['value' => 'storage/uploads/pdf/' . $filename, 'type' => 'file']
            );
        }

        // Handle Dashboard Hero Image
        if ($request->hasFile('dashboard_hero_image')) {
            $file = $request->file('dashboard_hero_image');
            $filename = 'hero_' . time() . '.webp';
            $this->uploadAndOptimizeToWebp($file, 'uploads/dashboard/' . $filename);
            
            $oldParams = Setting::where('key', 'dashboard_hero_image')->value('value');
            if ($oldParams && Storage::disk('public')->exists(str_replace('storage/', '', $oldParams))) {
                 Storage::disk('public')->delete(str_replace('storage/', '', $oldParams));
            }

            Setting::updateOrCreate(
                ['key' => 'dashboard_hero_image'],
                ['value' => 'storage/uploads/dashboard/' . $filename, 'type' => 'image']
            );
        }

        // Handle Dashboard About Image 1
        if ($request->hasFile('dashboard_about_image_1')) {
            $file = $request->file('dashboard_about_image_1');
            $filename = 'about1_' . time() . '.webp';
            $this->uploadAndOptimizeToWebp($file, 'uploads/dashboard/' . $filename);
            
            $oldParams = Setting::where('key', 'dashboard_about_image_1')->value('value');
            if ($oldParams && Storage::disk('public')->exists(str_replace('storage/', '', $oldParams))) {
                 Storage::disk('public')->delete(str_replace('storage/', '', $oldParams));
            }

            Setting::updateOrCreate(
                ['key' => 'dashboard_about_image_1'],
                ['value' => 'storage/uploads/dashboard/' . $filename, 'type' => 'image']
            );
        }

        // Handle Dashboard About Image 2
        if ($request->hasFile('dashboard_about_image_2')) {
            $file = $request->file('dashboard_about_image_2');
            $filename = 'about2_' . time() . '.webp';
            $this->uploadAndOptimizeToWebp($file, 'uploads/dashboard/' . $filename);
             
            $oldParams = Setting::where('key', 'dashboard_about_image_2')->value('value');
            if ($oldParams && Storage::disk('public')->exists(str_replace('storage/', '', $oldParams))) {
                 Storage::disk('public')->delete(str_replace('storage/', '', $oldParams));
            }

            Setting::updateOrCreate(
                ['key' => 'dashboard_about_image_2'],
                ['value' => 'storage/uploads/dashboard/' . $filename, 'type' => 'image']
            );
        }

        // Handle Video Upload
        if ($request->hasFile('dashboard_video_url')) {
            $file = $request->file('dashboard_video_url');
            $filename = 'video_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('uploads/video', $filename, 'public');
             
            $oldParams = Setting::where('key', 'dashboard_video_url')->value('value');
            if ($oldParams && Storage::disk('public')->exists(str_replace('storage/', '', $oldParams))) {
                 Storage::disk('public')->delete(str_replace('storage/', '', $oldParams));
            }

            Setting::updateOrCreate(
                ['key' => 'dashboard_video_url'],
                ['value' => 'storage/uploads/video/' . $filename, 'type' => 'file']
            );
        }

        // Handle Profile Page Images (5 slot)
        $profileImageKeys = ['profile_image_main', 'profile_image_1', 'profile_image_2', 'profile_image_3', 'profile_cert_image'];
        foreach ($profileImageKeys as $pk) {
            if ($request->hasFile($pk)) {
                $file = $request->file($pk);
                $filename = $pk . '_' . time() . '.webp';
                $this->uploadAndOptimizeToWebp($file, 'uploads/profile/' . $filename);
                
                $old = Setting::where('key', $pk)->value('value');
                if ($old && Storage::disk('public')->exists(str_replace('storage/', '', $old))) {
                    Storage::disk('public')->delete(str_replace('storage/', '', $old));
                }
                
                Setting::updateOrCreate(
                    ['key' => $pk],
                    ['value' => 'storage/uploads/profile/' . $filename, 'type' => 'image']
                );
            }
        }

        // Identify updated sections for logging
        $updatedSections = [];
        $keyMap = [
            'page_company_profile_content' => 'Profil Perusahaan',
            'page_profile_cert_content' => 'Sertifikasi & Lokasi',
            'page_visi_content' => 'Visi',
            'page_misi_content' => 'Misi',
            'dashboard_hero_title' => 'Judul Hero Dashboard',
            'dashboard_hero_subtitle' => 'Subjudul Hero',
            'dashboard_hero_image' => 'Gambar Hero Banner',
            'page_about_content' => 'Tentang Kami (Dashboard)',
            'dashboard_about_image_1' => 'Gambar About 1',
            'dashboard_about_image_2' => 'Gambar About 2',
            'dashboard_video_title' => 'Judul Video',
            'dashboard_video_desc' => 'Deskripsi Video',
            'dashboard_video_url' => 'File Video',
            'page_team_pdf' => 'PDF Struktur Organisasi',
            'contact_phone' => 'No. Telepon',
            'contact_email_1' => 'Email 1',
            'contact_email_2' => 'Email 2',
            'contact_address' => 'Alamat',
            'contact_maps_link' => 'Link Maps',
            'contact_hours_mon_fri' => 'Jam Kerja (Senin-Jumat)',
            'contact_hours_sat' => 'Jam Kerja (Sabtu)'
        ];

        foreach ($data as $key => $value) {
            if (isset($keyMap[$key])) {
                $updatedSections[] = $keyMap[$key];
            }
        }

        if ($request->hasFile('page_team_pdf')) {
            $updatedSections[] = $keyMap['page_team_pdf'];
        }

        if ($request->hasFile('dashboard_hero_image')) {
            $updatedSections[] = $keyMap['dashboard_hero_image'];
        }

        $description = 'Memperbarui konten: ' . implode(', ', array_unique($updatedSections));
        if (strlen($description) > 255) {
            $description = substr($description, 0, 252) . '...';
        }

        // Log Activity
        ActivityLog::create([
            'admin_id' => Auth::guard('admin')->id(),
            'action' => 'update',
            'description' => $description,
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
        ]);

        return redirect()->back()->with('success', 'Konten halaman berhasil diperbarui');
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.webp';
            $this->uploadAndOptimizeToWebp($file, 'uploads/pages/' . $filename);
            return response()->json(['location' => asset('storage/uploads/pages/' . $filename)]);
        }
        return response()->json(['error' => 'No file uploaded'], 400);
    }
}
