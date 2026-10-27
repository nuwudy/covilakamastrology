<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\ConsultationController as AdminConsultationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MediaLibraryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\TranslationController as AdminTranslationController;
use App\Http\Controllers\Admin\VideoController as AdminVideoController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\RazorpayController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\VideoController;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Support\Facades\Route;

// Public Front-End Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Exclusive Vedic Astrology Video Gallery (Cinema / Movie Showcase)
Route::get('/videos', [VideoController::class, 'index'])->name('videos.index');
Route::get('/videos/{id}', [VideoController::class, 'show'])->name('videos.show');

Route::post('/calculate-dob', [ConsultationController::class, 'calculateDob'])->name('consultations.calculate-dob');
Route::patch('/consultations/{id}/service', [ConsultationController::class, 'updateService'])->name('consultations.update-service');
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

// Razorpay Compliance Policy Routes
Route::get('/about-us', [PolicyController::class, 'about'])->name('policies.about');
Route::get('/contact', [PolicyController::class, 'contact'])->name('policies.contact');
Route::get('/terms-and-conditions', [PolicyController::class, 'terms'])->name('policies.terms');
Route::get('/privacy-policy', [PolicyController::class, 'privacy'])->name('policies.privacy');
Route::get('/refund-policy', [PolicyController::class, 'refund'])->name('policies.refund');
Route::get('/shipping-policy', [PolicyController::class, 'shipping'])->name('policies.shipping');

// Razorpay Standard Checkout Frontend & Web Aliases
Route::get('/checkout', [RazorpayController::class, 'checkoutPage'])->name('razorpay.checkout');
Route::post('/api/create-order', [RazorpayController::class, 'createOrder'])->name('razorpay.create-order');
Route::post('/api/verify-payment', [RazorpayController::class, 'verifyPayment'])->name('razorpay.verify-payment');

// Vedic Bookstore & Astrology Services Shop Routes
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{slug}', [ShopController::class, 'show'])->name('shop.show');
Route::post('/checkout/create-order', [ShopController::class, 'createRazorpayOrder'])->name('shop.create-order');
Route::post('/checkout/verify-payment', [ShopController::class, 'verifyPayment'])->name('shop.verify-payment');
Route::get('/orders/{order_number}/confirmation', [ShopController::class, 'confirmation'])->name('shop.confirmation');
Route::get('/orders/{order_number}/download-jathakam', [ShopController::class, 'downloadJathakam'])->name('shop.download-jathakam');

Route::get('/sitemap.xml', function () {
    $posts = \App\Models\Post::where('is_published', true)->orderBy('updated_at', 'desc')->get();
    $products = Product::where('is_active', true)->get();
    $videos = \App\Models\Video::where('is_active', true)->get();
    $xml = '<?xml version="1.0" encoding="UTF-8"?>';
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    $xml .= '<url><loc>' . url('/') . '</loc><changefreq>weekly</changefreq><priority>1.0</priority></url>';
    $xml .= '<url><loc>' . route('videos.index') . '</loc><changefreq>daily</changefreq><priority>0.9</priority></url>';
    $xml .= '<url><loc>' . route('shop.index') . '</loc><changefreq>daily</changefreq><priority>0.9</priority></url>';
    $xml .= '<url><loc>' . url('/blog') . '</loc><changefreq>daily</changefreq><priority>0.8</priority></url>';
    $xml .= '<url><loc>' . route('policies.about') . '</loc><changefreq>monthly</changefreq><priority>0.8</priority></url>';
    $xml .= '<url><loc>' . route('policies.contact') . '</loc><changefreq>monthly</changefreq><priority>0.8</priority></url>';
    $xml .= '<url><loc>' . route('policies.terms') . '</loc><changefreq>monthly</changefreq><priority>0.6</priority></url>';
    $xml .= '<url><loc>' . route('policies.privacy') . '</loc><changefreq>monthly</changefreq><priority>0.6</priority></url>';
    $xml .= '<url><loc>' . route('policies.refund') . '</loc><changefreq>monthly</changefreq><priority>0.6</priority></url>';
    $xml .= '<url><loc>' . route('policies.shipping') . '</loc><changefreq>monthly</changefreq><priority>0.6</priority></url>';
    $xml .= '<url><loc>' . url('/visiting-card') . '</loc><changefreq>monthly</changefreq><priority>0.7</priority></url>';

    foreach ($products as $prod) {
        $xml .= '<url>';
        $xml .= '<loc>' . route('shop.show', $prod->slug) . '</loc>';
        $xml .= '<lastmod>' . $prod->updated_at->toAtomString() . '</lastmod>';
        $xml .= '<changefreq>weekly</changefreq>';
        $xml .= '<priority>0.8</priority>';
        $xml .= '</url>';
    }

    foreach ($posts as $post) {
        $xml .= '<url>';
        $xml .= '<loc>' . route('blog.show', $post->slug) . '</loc>';
        $xml .= '<lastmod>' . $post->updated_at->toAtomString() . '</lastmod>';
        $xml .= '<changefreq>monthly</changefreq>';
        $xml .= '<priority>0.8</priority>';
        $xml .= '</url>';
    }
    $xml .= '</urlset>';
    return response($xml, 200)->header('Content-Type', 'text/xml');
});

// Admin Guest Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

// Protected Admin Dashboard Routes (Classic Fixed Left-Sidebar)
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    // 1. Dashboard Overview
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 2. Orders & Razorpay Transactions
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::post('/orders/{id}/status', [AdminOrderController::class, 'updateDeliveryStatus'])->name('orders.status');
    Route::delete('/orders/{id}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');

    // 3. Books & Publications (Full CRUD)
    Route::resource('books', AdminBookController::class)->except(['show']);

    // 4. Vedic Astrology Video Gallery (Full CRUD & Smart YouTube Parser)
    Route::resource('videos', AdminVideoController::class)->except(['show']);
    Route::post('/videos/{video}/toggle', [AdminVideoController::class, 'toggleStatus'])->name('videos.toggle');

    // 4. Vedic Wisdom Repository: Astrology Articles & Blog (Full CRUD)
    Route::resource('posts', AdminPostController::class)->except(['show']);

    // 5. Consultation & Free DOB Leads
    Route::get('/consultations', [AdminConsultationController::class, 'index'])->name('consultations.index');
    Route::post('/consultations/{consultation}/status', [AdminConsultationController::class, 'updateStatus'])->name('consultations.status');
    Route::delete('/consultations/{consultation}', [AdminConsultationController::class, 'destroy'])->name('consultations.destroy');

    // 6. 4-Language Astrology Content
    Route::get('/translations', [AdminTranslationController::class, 'index'])->name('translations.index');
    Route::put('/translations/{translation}', [AdminTranslationController::class, 'update'])->name('translations.update');

    // 7. Settings, Profile & Contact
    Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [AdminSettingController::class, 'update'])->name('settings.update');

    // 8. Media Library (Auto-WebP Engine)
    Route::get('/media', [MediaLibraryController::class, 'index'])->name('media.index');
    Route::post('/media', [MediaLibraryController::class, 'store'])->name('media.store');
    Route::put('/media/{id}', [MediaLibraryController::class, 'update'])->name('media.update');
    Route::delete('/media/{id}', [MediaLibraryController::class, 'destroy'])->name('media.destroy');
});
