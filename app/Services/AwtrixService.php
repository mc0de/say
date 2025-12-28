<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use PhpMqtt\Client\Facades\MQTT;

class AwtrixService
{
    protected string $prefix;

    public function __construct()
    {
        $this->prefix = config('awtrix.prefix');
    }

    public function globalTextColor(string $hex): void
    {
        $endpoint = '/settings';

        $this->client($endpoint, ['TCOL' => $hex]);
    }

    public function notify(string $text, array $options = []): bool
    {
        $endpoint = '/notify';

        $payload = array_merge([
            'text'        => $text,
            'rainbow'     => false,
            'icon'        => '25596',
            'duration'    => 15,
            'hold'        => false,
            'pushIcon'    => 2,
            'color'       => '#FFFFFF',
            'scrollSpeed' => 100,
            'hold'        => true,
        ], $options);

        try {
            MQTT::publish($this->prefix . $endpoint, json_encode($payload));

            return true;
        } catch (Exception $e) {
            Log::error('Awtrix MQTT connection error', [
                'message' => $e->getMessage(),
            ]);

            return false;
        }
    }

    protected function client(string $endpoint, array $payload): void
    {
        MQTT::publish($this->prefix . $endpoint, json_encode($payload));
    }
}
