<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except('_token', '_method');

        foreach ($data as $key => $value) {
            if ($request->hasFile($key)) {
                $file = $request->file($key);
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('settings', $filename, 'public');
                
                // Get old value to delete if needed
                $oldSetting = Setting::where('key', $key)->first();
                if ($oldSetting && $oldSetting->type == 'image' && $oldSetting->value) {
                    Storage::delete(str_replace('storage/', 'public/', $oldSetting->value));
                }

                $value = 'storage/settings/' . $filename;
                
                Setting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $value, 'type' => 'image']
                );
            } else {
                Setting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $value, 'type' => 'text']
                );
            }
        }

        return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui');
    }
}
