<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SayController;

Route::get('/', [SayController::class, 'index'])->name('say.index');
Route::post('/say', [SayController::class, 'submit'])->name('say.submit');
