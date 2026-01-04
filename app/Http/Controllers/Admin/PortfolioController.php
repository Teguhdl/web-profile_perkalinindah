<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PortfolioController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.permission:portfolio.view')->only(['index', 'show']);
        $this->middleware('check.permission:portfolio.create')->only(['create', 'store']);
        $this->middleware('check.permission:portfolio.edit')->only(['edit', 'update']);
        $this->middleware('check.permission:portfolio.delete')->only(['destroy']);
    }
    public function index()
    {
        $portfolios = Portfolio::latest()->paginate(10);
        return view('admin.portfolios.index', compact('portfolios'));
    }

    public function create()
    {
        return view('admin.portfolios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'client' => 'nullable|string|max:255',
            'year' => 'nullable|integer',
            'status' => 'required|in:Publish,Draft',
            'description' => 'required',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('portfolios', $filename, 'public');
            $imagePath = 'storage/portfolios/' . $filename;
        }

        $portfolio = Portfolio::create([
            'title' => $request->title,
            'image' => $imagePath,
            'client' => $request->client,
            'year' => $request->year,
            'status' => $request->status,
            'description' => $request->description,
        ]);

        ActivityLog::create([
            'admin_id' => Auth::guard('admin')->id(),
            'action' => 'create',
            'description' => 'Menambahkan portofolio: ' . $portfolio->title,
            'subject_type' => Portfolio::class,
            'subject_id' => $portfolio->id,
        ]);

        return redirect()->route('admin.portfolios.index')->with('success', 'Portofolio berhasil ditambahkan');
    }

    public function edit(Portfolio $portfolio)
    {
        return view('admin.portfolios.edit', compact('portfolio'));
    }

    public function update(Request $request, Portfolio $portfolio)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'client' => 'nullable|string|max:255',
            'year' => 'nullable|integer',
            'status' => 'required|in:Publish,Draft',
            'description' => 'required',
        ]);

        if ($request->hasFile('image')) {
            if ($portfolio->image) {
                $oldPath = str_replace('storage/', 'public/', $portfolio->image);
                if (Storage::exists($oldPath)) {
                    Storage::delete($oldPath);
                }
            }

            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('portfolios', $filename, 'public');
            $portfolio->image = 'storage/portfolios/' . $filename;
        }

        $portfolio->title = $request->title;
        $portfolio->client = $request->client;
        $portfolio->year = $request->year;
        $portfolio->status = $request->status;
        $portfolio->description = $request->description;
        $portfolio->save();

        ActivityLog::create([
            'admin_id' => Auth::guard('admin')->id(),
            'action' => 'update',
            'description' => 'Memperbarui portofolio: ' . $portfolio->title,
            'subject_type' => Portfolio::class,
            'subject_id' => $portfolio->id,
        ]);

        return redirect()->route('admin.portfolios.index')->with('success', 'Portofolio berhasil diperbarui');
    }

    public function destroy(Portfolio $portfolio)
    {
        if ($portfolio->image) {
            $oldPath = str_replace('storage/', 'public/', $portfolio->image);
            if (Storage::exists($oldPath)) {
                Storage::delete($oldPath);
            }
        }
        
        $portfolio->delete();

        ActivityLog::create([
            'admin_id' => Auth::guard('admin')->id(),
            'action' => 'delete',
            'description' => 'Menghapus portofolio: ' . $portfolio->title,
            'subject_type' => Portfolio::class,
            'subject_id' => $portfolio->id,
        ]);
        return redirect()->route('admin.portfolios.index')->with('success', 'Portofolio berhasil dihapus');
    }
}
