<?php

use App\Http\Controllers\V1\AppController;
use Illuminate\Support\Facades\Route;

Route::post('/v1/generate', [AppController::class, 'generate'])->name('generate');
