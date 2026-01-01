<?php

namespace App\Facades;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Response vilniusPlace()
 * @method static Response places(string $placeCode)
 *
 * @see \App\Services\Meteo\MeteoService
 */
class Meteo extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'meteo';
    }
}

