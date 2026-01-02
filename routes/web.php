<?php

use App\Http\Controllers\MeteoController;
use App\Http\Controllers\SayController;
use App\Http\Controllers\SettingsController;
use App\Http\Middleware\IsLocal;
use Illuminate\Support\Facades\Route;

Route::get('/', [SayController::class, 'index'])->name('say.index');
Route::post('/say', [SayController::class, 'submit'])->name('say.submit');

Route::middleware(IsLocal::class)
    ->group(function () {
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');

        Route::post('/settings', [SettingsController::class, 'store'])->name('settings.store');

        Route::get('/meteo', [MeteoController::class, 'index'])->name('meteo');
    });
