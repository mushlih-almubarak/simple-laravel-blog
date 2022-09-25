<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\DashboardPostsController;
use App\Http\Controllers\RegistrationEmailVerificationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Jika yang diakses URL utama
Route::get('/', [HomeController::class, 'index']);

// Memanggil controller AboutController, dan menjalankan method index
Route::get('/tentang-saya', [AboutController::class, 'index']);

Route::get('/blog', [PostController::class, 'index']);

// {url} = apapun yang ditulis setelah blog/
// {url} = wildcard. & kita yang buat keyword 'slug'nya sendiri ngambil dari nama kolom di database
Route::get('/blog/{data:slug}', [PostController::class, 'post']);

Route::get('/kategori', [CategoryController::class, 'all']);

Route::get('/penulis', [UserController::class, 'all']);

Route::get('/login', [loginController::class, 'index'])->name('login')->middleware('guest');

Route::post('/login', [loginController::class, 'auth'])->middleware('guest');

Route::get('/daftar', [RegistrationController::class, 'index'])->middleware('guest');

Route::post('/daftar', [RegistrationController::class, 'store'])->middleware('guest');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified']);

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth');

Route::resource('/dashboard/artikel', DashboardPostsController::class)->except('show')->middleware(['auth', 'verified']);

Route::get('/dashboard/artikel/{post}/edit/delete-image', [DashboardPostsController::class, 'deleteImage'])->middleware(['auth', 'verified']);

Route::resource('/dashboard/kategori', AdminCategoryController::class)->middleware(['admin', 'verified']);

Route::controller(RegistrationEmailVerificationController::class)->group(function () {
    Route::get('/email/verifikasi', 'index')->middleware(['auth', 'UnVerified'])->name('verification.notice');
    Route::get('/email/verifikasi/{id}/{hash}', 'verify')->middleware(['auth', 'signed', 'UnVerified'])->name('verification.verify');
    Route::post('/email/verifikasi', 'resend')->middleware(['auth', 'throttle:6,1', 'UnVerified'])->name('verification.send');
});

Route::controller(PasswordResetController::class)->group(function () {
    Route::get('/lupa-password', 'index')->middleware('guest')->name('password.request');
    Route::post('/lupa-password', 'reset')->middleware('guest')->name('password.email');
    Route::get('/password/reset/{token}', 'updateGet')->middleware('guest')->name('password.reset');
    Route::post('/password/reset/{token}', 'update')->middleware('guest')->name('password.update');
});

Route::get('/dashboard/users', [UserController::class, 'userList'])->middleware(['admin', 'verified']);

Route::get('/login-user/{id}', [LoginController::class, 'loginUser'])->middleware(['admin', 'verified']);

Route::post('/dashboard/artikel/add-image', [DashboardPostsController::class, 'addImage'])->middleware(['auth', 'verified']);

// Clear cache
Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    return "Cache is cleared";
})->middleware(['auth', 'admin']);

// Optimize
Route::get('/optimize', function () {
    Artisan::call('optimize');
    return "Cache is optimized";
})->middleware(['auth', 'admin']);
