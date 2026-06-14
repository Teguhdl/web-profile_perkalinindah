@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-bold text-gray-900">Dashboard Overview</h2>
    <p class="text-gray-500 mt-1">Summary of your website's content and performance.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Card Produk -->
    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-blue-50 rounded-xl text-blue-600">
                <span class="material-symbols-outlined">inventory_2</span>
            </div>
        </div>
        <div>
            <p class="text-gray-500 text-sm font-medium">Total Produk</p>
            <p class="text-3xl font-bold text-gray-900 mt-1">{{ \App\Models\Product::count() }}</p>
        </div>
    </div>

    <!-- Card Mitra -->
    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-purple-50 rounded-xl text-purple-600">
                <span class="material-symbols-outlined">handshake</span>
            </div>
        </div>
        <div>
            <p class="text-gray-500 text-sm font-medium">Total Mitra</p>
            <p class="text-3xl font-bold text-gray-900 mt-1">{{ \App\Models\Mitra::count() }}</p>
        </div>
    </div>

    <!-- Card Portofolio -->
    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition">
         <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-orange-50 rounded-xl text-orange-600">
                <span class="material-symbols-outlined">photo_library</span>
            </div>
        </div>
        <div>
            <p class="text-gray-500 text-sm font-medium">Portofolio</p>
            <p class="text-3xl font-bold text-gray-900 mt-1">{{ \App\Models\Portfolio::count() }}</p>
        </div>
    </div>
    
     <!-- Card Admin -->
    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition">
         <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-red-50 rounded-xl text-red-600">
                <span class="material-symbols-outlined">admin_panel_settings</span>
            </div>
        </div>
        <div>
            <p class="text-gray-500 text-sm font-medium">System Status</p>
            <p class="text-xl font-bold text-gray-900 mt-1">Active</p>
        </div>
    </div>
</div>

@if(isset($settings['google_analytics_embed']) && !empty($settings['google_analytics_embed']))
<!-- Google Analytics Looker Studio Dashboard -->
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-8">
    <div class="flex items-center gap-3 mb-6">
        <div class="p-2.5 bg-red-50 text-red-600 rounded-xl">
            <span class="material-symbols-outlined">trending_up</span>
        </div>
        <div>
            <h3 class="text-lg font-bold text-gray-900">Statistik Pengunjung Website</h3>
            <p class="text-xs text-gray-400">Analisis traffic dan kunjungan langsung dari Google Analytics</p>
        </div>
    </div>
    
    <div class="relative w-full rounded-xl overflow-hidden border border-gray-100" style="height: 550px;">
        <iframe 
            src="{{ $settings['google_analytics_embed'] }}" 
            frameborder="0" 
            style="border:0; width:100%; height:100%;" 
            allowfullscreen>
        </iframe>
    </div>
</div>
@endif

<!-- Quick Actions / Table Placeholder -->
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-bold text-gray-900">Recent Activity</h3>
    </div>
    
    <div class="space-y-4">
        @forelse($activities as $activity)
        <div class="flex items-start gap-4 p-4 rounded-xl {{ $loop->even ? 'bg-gray-50' : 'bg-white border border-gray-100' }}">
            <div class="h-10 w-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-sm">
                    @if($activity->action == 'create') add_circle
                    @elseif($activity->action == 'update') edit
                    @elseif($activity->action == 'delete') delete
                    @else history @endif
                </span>
            </div>
            <div class="flex-1">
                <p class="text-sm text-gray-800 font-medium">{{ $activity->description }}</p>
                <div class="flex items-center gap-2 mt-1">
                    <span class="text-xs text-gray-500">by {{ $activity->admin->name ?? 'System' }}</span>
                    <span class="text-xs text-gray-300">•</span>
                    <span class="text-xs text-gray-400">{{ $activity->created_at->diffForHumans() }}</span>
                </div>
            </div>
        </div>
        @empty
        <div class="text-gray-500 text-sm text-center py-12 bg-gray-50 rounded-xl border border-dashed border-gray-200">
            No recent activity logs found.
        </div>
        @endforelse
    </div>
</div>
@endsection