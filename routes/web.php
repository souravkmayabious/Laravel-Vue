<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SocialLoginController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

//for vue js
// Route::get('/{any}', function () {
//     return view('welcome');
// })->where('any', '.*');



Route::get('/pay', [PaymentController::class, 'index'])->name('payment.index');
Route::post('/payment', [PaymentController::class, 'createOrder'])->name('payment.create');
Route::post('/payment-success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
Route::get('/payment-success-page', [PaymentController::class, 'successPage'])->name('payment.success.page');

Route::get('social-login', [SocialLoginController::class, 'loadLogins']);
Route::get('login/{provider}', [SocialLoginController::class, 'redirectToProvider']);
Route::get('login/{provider}/callback', [SocialLoginController::class, 'handleProviderCallback']);

Route::get('/dashboard', function () {
    return view('blade.dashboard'); // This can be your dashboard page view
})->name('dashboard');

// Login page (if needed, fallback for non-social login users)
Route::get('login', function () {
    return view('auth.login'); // This can be your login page view
})->name('login');

// Logout route
Route::post('logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');