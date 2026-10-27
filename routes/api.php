<?php

use App\Http\Controllers\RazorpayController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Razorpay Standard Checkout API Routes
|--------------------------------------------------------------------------
|
| STEP 1: POST /api/create-order
| STEP 3: POST /api/verify-payment
|
*/

Route::post('/create-order', [RazorpayController::class, 'createOrder'])->name('api.razorpay.create-order');
Route::post('/verify-payment', [RazorpayController::class, 'verifyPayment'])->name('api.razorpay.verify-payment');
