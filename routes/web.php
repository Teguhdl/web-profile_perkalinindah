<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\PageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [PageController::class, 'home'])->name('home');

// Route khusus Produk
Route::get('/produk/{slug}', [PageController::class, 'productDetail'])->name('product.detail');
Route::get('/portofolio/{id}', [PageController::class, 'portfolioDetail'])->name('portfolio.detail');

// Route Contact
Route::post('/contact', [\App\Http\Controllers\Web\ContactController::class, 'store'])->name('contact.store')->middleware('throttle:2,1');

// Route dinamis semua halaman lain
Route::get('/{slug}', [PageController::class, 'show'])->name('page.show');


