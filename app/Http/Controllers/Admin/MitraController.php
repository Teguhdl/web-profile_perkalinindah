<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mitra;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use App\Traits\UploadsWebP;

class MitraController extends Controller
{
    use UploadsWebP;
    public function __construct()
    {
        $this->middleware('check.permission:mitra.view')->only(['index', 'show']);
        $this->middleware('check.permission:mitra.create')->only(['create', 'store']);
        $this->middleware('check.permission:mitra.edit')->only(['edit', 'update']);
        $this->middleware('check.permission:mitra.delete')->only(['destroy']);
    }
    public function index()
    {
        $mitras = Mitra::latest()->paginate(10);
        return view('admin.mitras.index', compact('mitras'));
    }

    public function create()
    {
        return view('admin.mitras.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable',
        ]);

        if ($request->hasFile('logo')) {
            $logoPath = $this->uploadImage($request->file('logo'), 'mitras');
        }

        $mitra = Mitra::create([
            'name' => $request->name,
            'logo' => $logoPath,
            'description' => $request->description,
        ]);

        ActivityLog::create([
            'admin_id' => Auth::guard('admin')->id(),
            'action' => 'create',
            'description' => 'Menambahkan mitra: ' . $mitra->name,
            'subject_type' => Mitra::class,
            'subject_id' => $mitra->id,
        ]);

        return redirect()->route('admin.mitras.index')->with('success', 'Mitra berhasil ditambahkan');
    }

    public function edit(Mitra $mitra)
    {
        return view('admin.mitras.edit', compact('mitra'));
    }

    public function update(Request $request, Mitra $mitra)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable',
        ]);

        if ($request->hasFile('logo')) {
            if ($mitra->logo) {
                $oldPath = str_replace('storage/', 'public/', $mitra->logo);
                if (Storage::exists($oldPath)) {
                    Storage::delete($oldPath);
                }
            }

            $mitra->logo = $this->uploadImage($request->file('logo'), 'mitras');
        }

        $mitra->name = $request->name;
        $mitra->description = $request->description;
        $mitra->save();

        ActivityLog::create([
            'admin_id' => Auth::guard('admin')->id(),
            'action' => 'update',
            'description' => 'Memperbarui mitra: ' . $mitra->name,
            'subject_type' => Mitra::class,
            'subject_id' => $mitra->id,
        ]);

        return redirect()->route('admin.mitras.index')->with('success', 'Mitra berhasil diperbarui');
    }

    public function destroy(Mitra $mitra)
    {
        if ($mitra->logo) {
            $oldPath = str_replace('storage/', 'public/', $mitra->logo);
            if (Storage::exists($oldPath)) {
                Storage::delete($oldPath);
            }
        }
        
        $mitra->delete();

        ActivityLog::create([
            'admin_id' => Auth::guard('admin')->id(),
            'action' => 'delete',
            'description' => 'Menghapus mitra: ' . $mitra->name,
            'subject_type' => Mitra::class,
            'subject_id' => $mitra->id,
        ]);
        return redirect()->route('admin.mitras.index')->with('success', 'Mitra berhasil dihapus');
    }
}
