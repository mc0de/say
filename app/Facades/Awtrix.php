<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static bool notify(string $text, array $options = [])
 *
 * @see \App\Services\AwtrixService
 */
class Awtrix extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'awtrix';
    }
}

