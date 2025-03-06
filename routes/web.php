<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

//for vue js
Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');
