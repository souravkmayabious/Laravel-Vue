<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
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