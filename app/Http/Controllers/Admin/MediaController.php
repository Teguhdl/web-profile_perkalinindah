<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaLibrary;
use App\Traits\UploadsWebP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    use UploadsWebP;

    public function __construct()
    {
        $this->middleware('check.permission:setting.view')->only(['index', 'browser', 'json']);
        $this->middleware('check.permission:setting.edit')->only(['upload', 'destroy', 'updateMeta']);
    }

    public function index(Request $request)
    {
        $q = MediaLibrary::query()->latest();
        if ($request->search) {
            $q->where('filename', 'like', "%{$request->search}%")
              ->orWhere('alt', 'like', "%{$request->search}%");
        }
        if ($request->type === 'image') $q->where('mime', 'like', 'image/%');
        if ($request->type === 'document') $q->where('mime', 'not like', 'image/%');

        $media = $q->paginate(24)->withQueryString();
        return view('admin.media.index', compact('media'));
    }

    /**
     * Media browser modal (untuk TinyMCE & forms).
     */
    public function browser(Request $request)
    {
        $q = MediaLibrary::query()->where('mime', 'like', 'image/%')->latest();
        if ($request->search) {
            $q->where('filename', 'like', "%{$request->search}%");
        }
        $media = $q->paginate(20);
        return view('admin.media.browser', compact('media'));
    }

    /**
     * Endpoint JSON untuk dipanggil TinyMCE file picker.
     */
    public function json()
    {
        $items = MediaLibrary::where('mime', 'like', 'image/%')
            ->latest()
            ->limit(100)
            ->get(['id', 'filename', 'path', 'mime', 'alt', 'title'])
            ->map(function ($m) {
                return [
                    'id'       => $m->id,
                    'title'    => $m->title ?: $m->filename,
                    'value'    => asset($m->path),
                    'filename' => $m->filename,
                    'alt'      => $m->alt,
                ];
            });
        return response()->json($items);
    }

    public function upload(Request $request)
    {
        // Pastikan ekspektasi JSON dikenali (TinyMCE & AJAX) supaya error pun keluar JSON.
        $wantsJson = $request->expectsJson() || $request->wantsJson() || $request->ajax()
            || str_contains((string) $request->header('Accept'), 'application/json');

        try {
            $request->validate([
                'file' => 'required|file|max:10240', // 10MB max
            ]);

            $file = $request->file('file');
            $mime = $file->getMimeType();
            $original = $file->getClientOriginalName();

            // Pastikan folder storage/app/public/media ada (penting di Windows).
            $mediaFolder = storage_path('app/public/media');
            if (!is_dir($mediaFolder)) {
                @mkdir($mediaFolder, 0775, true);
            }

            // Convert ke WebP kalau gambar, kalau bukan simpan original
            if (str_starts_with($mime, 'image/')) {
                $path = $this->uploadImage($file, 'media');
                $mime = 'image/webp';
            } else {
                $stored = $file->storeAs('media', time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension(), 'public');
                $path = 'storage/' . $stored;
            }

            $abs = public_path($path);
            $size = file_exists($abs) ? filesize($abs) : 0;

            $media = MediaLibrary::create([
                'filename'    => $original,
                'path'        => $path,
                'mime'        => $mime,
                'size'        => $size,
                'alt'         => $request->alt,
                'title'       => $request->title,
                'uploaded_by' => Auth::guard('admin')->id(),
            ]);

            if ($wantsJson) {
                return response()->json([
                    'location' => asset($media->path),
                    'url'      => asset($media->path),
                    'id'       => $media->id,
                    'filename' => $media->filename,
                    'mime'     => $media->mime,
                ]);
            }

            return back()->with('success', 'File berhasil diupload.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($wantsJson) {
                return response()->json([
                    'error'   => $e->validator->errors()->first(),
                    'message' => $e->validator->errors()->first(),
                ], 422);
            }
            throw $e;
        } catch (\Throwable $e) {
            \Log::error('Media upload failed: ' . $e->getMessage());
            if ($wantsJson) {
                return response()->json([
                    'error'   => 'Upload gagal: ' . $e->getMessage(),
                    'message' => 'Upload gagal: ' . $e->getMessage(),
                ], 500);
            }
            return back()->with('error', 'Upload gagal: ' . $e->getMessage());
        }
    }

    public function updateMeta(Request $request, MediaLibrary $media)
    {
        $media->update($request->only(['alt', 'title']));
        return response()->json(['ok' => true]);
    }

    public function destroy(MediaLibrary $media)
    {
        $rel = str_replace('storage/', '', $media->path);
        Storage::disk('public')->delete($rel);
        $media->delete();

        if (request()->expectsJson()) return response()->json(['ok' => true]);
        return back()->with('success', 'Media berhasil dihapus.');
    }
}
