<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('app');
});

// catch URL and display the App; Let Vue router handles the routing
Route::get('/{any?}', function () {
    return view('app');
})->where('any', '.*');
