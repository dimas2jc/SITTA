<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route("login");
});

Route::get('/login', function () {
    return view('auth');
})->name('login');

Route::get('/dashboard', function () {
    return view('pages.dashboard');
});

Route::get('/bahan-ajar', function () {
    return view('pages.bahanAjar');
});

Route::get('/tracking-pengiriman', function () {
    return view('pages.tracking');
});

Route::prefix('vue')->group( function () {
    Route::get('tracking-pengiriman', function () {
        return view('pages.tracking_vue');
    });
    Route::get('bahan-ajar', function () {
        return view('pages.stock_vue');
    });
});
