@extends('admin.layouts.app')

@section('title', 'Web Profile Settings')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900">Settings</h2>
        <p class="text-gray-500 mt-1">Manage your company and system settings</p>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <h3 class="text-xl font-bold text-gray-900 mb-1">Company Information</h3>
            <p class="text-gray-500 text-sm mb-8">Update your company details and contact information</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Company Name</label>
                    <input type="text" name="system_name" value="{{ $settings['system_name'] ?? '' }}" class="w-full bg-gray-50 border-gray-100 rounded-lg px-4 py-3 text-gray-700 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors" placeholder="e.g. PT. Perkalin Indah">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tagline / Slogan</label>
                     <input type="text" name="system_slogan" value="{{ $settings['system_slogan'] ?? '' }}" class="w-full bg-gray-50 border-gray-100 rounded-lg px-4 py-3 text-gray-700 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors" placeholder="Company Slogan">
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Address</label>
                <textarea name="contact_address" rows="3" class="w-full bg-gray-50 border-gray-100 rounded-lg px-4 py-3 text-gray-700 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors" placeholder="Full company address">{{ $settings['contact_address'] ?? '' }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email Utama</label>
                    <div class="relative mb-3">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                             <span class="material-symbols-outlined" style="font-size: 18px;">mail</span>
                        </span>
                        <input type="email" name="contact_email" value="{{ $settings['contact_email'] ?? '' }}" class="w-full bg-gray-50 border-gray-100 rounded-lg pl-10 px-4 py-3 text-gray-700 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors" placeholder="marketing@company.com">
                    </div>
                    
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email Kedua (Opsional)</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                             <span class="material-symbols-outlined" style="font-size: 18px;">alternate_email</span>
                        </span>
                        <input type="email" name="contact_email_2" value="{{ $settings['contact_email_2'] ?? '' }}" class="w-full bg-gray-50 border-gray-100 rounded-lg pl-10 px-4 py-3 text-gray-700 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors" placeholder="support@company.com">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Phone</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                             <span class="material-symbols-outlined" style="font-size: 18px;">call</span>
                        </span>
                        <input type="text" name="contact_phone" value="{{ $settings['contact_phone'] ?? '' }}" class="w-full bg-gray-50 border-gray-100 rounded-lg pl-10 px-4 py-3 text-gray-700 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors" placeholder="+62 21 ...">
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Company Description</label>
                <textarea name="system_description" rows="4" class="w-full bg-gray-50 border-gray-100 rounded-lg px-4 py-3 text-gray-700 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors" placeholder="Brief description about the company...">{{ $settings['system_description'] ?? '' }}</textarea>
            </div>

            <!-- Business Hours (Added per request) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                     <label class="block text-sm font-semibold text-gray-700 mb-2">Business Hours (Mon-Fri)</label>
                     <input type="text" name="contact_hours_mon_fri" value="{{ $settings['contact_hours_mon_fri'] ?? '' }}" class="w-full bg-gray-50 border-gray-100 rounded-lg px-4 py-3 text-gray-700 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors" placeholder="8:00 AM – 6:00 PM">
                </div>
                 <div>
                     <label class="block text-sm font-semibold text-gray-700 mb-2">Business Hours (Sat)</label>
                     <input type="text" name="contact_hours_sat" value="{{ $settings['contact_hours_sat'] ?? '' }}" class="w-full bg-gray-50 border-gray-100 rounded-lg px-4 py-3 text-gray-700 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors" placeholder="9:00 AM – 2:00 PM">
                </div>
            </div>

            <hr class="border-gray-100 my-8">

            <h3 class="text-lg font-bold text-gray-900 mb-4">Branding & Social</h3>
            
            <div class="flex items-start gap-6 mb-8">
                <div class="shrink-0">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Company Logo</label>
                    @if(isset($settings['system_logo']))
                        <div class="h-32 w-32 bg-gray-50 border-2 border-dashed border-gray-200 rounded-xl flex items-center justify-center p-2 overflow-hidden relative group">
                            <img class="h-full w-full object-contain" src="{{ asset($settings['system_logo']) }}" alt="Logo">
                        </div>
                    @else
                        <div class="h-32 w-32 bg-gray-50 border-2 border-dashed border-gray-200 rounded-xl flex items-center justify-center text-gray-400">
                             <span class="material-symbols-outlined" style="font-size: 32px">image</span>
                        </div>
                    @endif
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Upload New Logo</label>
                    <input type="file" name="system_logo" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 cursor-pointer"/>
                    <p class="mt-2 text-xs text-gray-400">Supported formats: PNG, JPG, GIF. Max size: 2MB.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div>
                     <label class="block text-sm font-semibold text-gray-700 mb-2">Facebook</label>
                     <input type="url" name="social_facebook" value="{{ $settings['social_facebook'] ?? '' }}" class="w-full bg-gray-50 border-gray-100 rounded-lg px-4 py-3 text-gray-700 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors" placeholder="https://facebook.com/...">
                </div>
                 <div>
                     <label class="block text-sm font-semibold text-gray-700 mb-2">Instagram</label>
                     <input type="url" name="social_instagram" value="{{ $settings['social_instagram'] ?? '' }}" class="w-full bg-gray-50 border-gray-100 rounded-lg px-4 py-3 text-gray-700 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors" placeholder="https://instagram.com/...">
                </div>
                 <div>
                     <label class="block text-sm font-semibold text-gray-700 mb-2">Twitter / X</label>
                     <input type="url" name="social_twitter" value="{{ $settings['social_twitter'] ?? '' }}" class="w-full bg-gray-50 border-gray-100 rounded-lg px-4 py-3 text-gray-700 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors" placeholder="https://twitter.com/...">
                </div>
            </div>

            <div class="flex pt-4">
                 <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-red-200 transform transition hover:-translate-y-0.5 flex items-center gap-2">
                    <span class="material-symbols-outlined">save</span>
                    Save Changes
                </button>
            </div>
            
        </div>
    </form>
</div>
@endsection
