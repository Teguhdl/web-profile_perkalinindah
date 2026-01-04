<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PageSettingController extends Controller
{
    public function index()
    {
        $settings = Setting::whereIn('key', [
            'page_company_profile_content',
            'page_profile_cert_content',
            'page_visi_content',
            'page_misi_content',
            'page_about_content'
        ])->pluck('value', 'key');

        return view('admin.page_settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except('_token', '_method', 'page_team_pdf');

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

        return redirect()->back()->with('success', 'Konten halaman berhasil diperbarui');
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('uploads/pages', $filename, 'public');
            return response()->json(['location' => asset('storage/uploads/pages/' . $filename)]);
        }
        return response()->json(['error' => 'No file uploaded'], 400);
    }
}
