<?php

use App\Facades\Awtrix;
use App\Facades\Meteo;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    Awtrix::meteo(Meteo::vilnius());
})->everyMinute();
