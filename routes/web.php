<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ConsultationController as AdminConsultationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MediaLibraryController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\TranslationController as AdminTranslationController;
use App\Http\Controllers\Admin\VideoController as AdminVideoController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\HomeController;
use App\Models\Setting;
use Illuminate\Support\Facades\Route;

// Public Front-End Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::post('/calculate-dob', [ConsultationController::class, 'calculateDob'])->name('consultations.calculate-dob');
Route::get('/prediction/{id}', [ConsultationController::class, 'showPrediction'])->name('consultations.prediction');
Route::post('/book-consultation', [ConsultationController::class, 'store'])->name('consultations.store');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

Route::get('/visiting-card', function () {
    $settings = Setting::all()->pluck('value', 'key')->toArray();
    return view('visiting-card.index', compact('settings'));
})->name('visiting-card');

Route::get('/visiting-card/print', function () {
    $settings = Setting::all()->pluck('value', 'key')->toArray();
    return view('visiting-card.print', compact('settings'));
})->name('visiting-card.print');

// Admin Guest Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

// Protected Admin Dashboard Routes (Classic Fixed Left-Sidebar)
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    // 1. Dashboard Overview
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 2. Vedic Astrology Video Gallery (Full CRUD & Smart YouTube Parser)
    Route::resource('videos', AdminVideoController::class)->except(['show']);
    Route::post('/videos/{video}/toggle', [AdminVideoController::class, 'toggleStatus'])->name('videos.toggle');

    // 3. Vedic Wisdom Repository: Astrology Articles & Blog (Full CRUD)
    Route::resource('posts', AdminPostController::class)->except(['show']);

    // 4. Consultation & Free DOB Leads
    Route::get('/consultations', [AdminConsultationController::class, 'index'])->name('consultations.index');
    Route::post('/consultations/{consultation}/status', [AdminConsultationController::class, 'updateStatus'])->name('consultations.status');
    Route::delete('/consultations/{consultation}', [AdminConsultationController::class, 'destroy'])->name('consultations.destroy');

    // 5. 4-Language Astrology Content
    Route::get('/translations', [AdminTranslationController::class, 'index'])->name('translations.index');
    Route::put('/translations/{translation}', [AdminTranslationController::class, 'update'])->name('translations.update');

    // 6. Settings, Profile & Contact
    Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [AdminSettingController::class, 'update'])->name('settings.update');

    // 7. Media Library (Auto-WebP Engine)
    Route::get('/media', [MediaLibraryController::class, 'index'])->name('media.index');
    Route::post('/media', [MediaLibraryController::class, 'store'])->name('media.store');
    Route::put('/media/{id}', [MediaLibraryController::class, 'update'])->name('media.update');
    Route::delete('/media/{id}', [MediaLibraryController::class, 'destroy'])->name('media.destroy');
});
