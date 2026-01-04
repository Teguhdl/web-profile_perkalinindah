<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $activities = \App\Models\ActivityLog::with('admin')->latest()->take(5)->get();
        
        return view('admin.dashboard', compact('activities'));
    }
}
