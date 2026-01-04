<?php 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;

Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::middleware('admin.auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Settings
    Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');

    // Products
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);

    // Mitras
    Route::resource('mitras', \App\Http\Controllers\Admin\MitraController::class);

    // Portfolios
    Route::resource('portfolios', \App\Http\Controllers\Admin\PortfolioController::class);

    // Admin & Role Management
    Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class)->middleware('check.permission:admin.view');
    Route::resource('admins', \App\Http\Controllers\Admin\AdminController::class)->middleware('check.permission:admin.view');
});
