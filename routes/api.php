<?php

use App\Http\Controllers\AstrologyReadingController;
use App\Http\Controllers\RazorpayController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Razorpay Standard Checkout & Astrology Engine API Routes
|--------------------------------------------------------------------------
|
| STEP 1: POST /api/create-order
| STEP 3: POST /api/verify-payment
| VEDIC:  POST /api/astrology/calculate
|
*/

Route::post('/create-order', [RazorpayController::class, 'createOrder'])->name('api.razorpay.create-order');
Route::post('/verify-payment', [RazorpayController::class, 'verifyPayment'])->name('api.razorpay.verify-payment');

Route::post('/astrology/calculate', [AstrologyReadingController::class, 'calculate'])->name('api.astrology.calculate');

