<?php

namespace App\Http\Controllers;

use App\Facades\Awtrix;
use App\Facades\Meteo;
use Carbon\Carbon;

class MeteoController extends Controller
{
    public function index()
    {
        $forecast = Meteo::vilnius();
        Awtrix::meteo($forecast);

        return $forecast->toArray();

        // return Meteo::longTermForecast('vilnius')->json();
    }
}
