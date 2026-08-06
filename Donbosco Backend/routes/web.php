<?php
use Illuminate\Support\Facades\Cache;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('/lang/{locale}', function ($locale) {

    if (in_array($locale, ['ar', 'en'])) {
        Session::put('locale', $locale);
    }

    return redirect()->back();
});
Route::get('/clear-cache', function() {
    Cache::flush();
});

