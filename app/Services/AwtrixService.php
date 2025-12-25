<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AwtrixService
{
    protected string $ip;
    protected string $port;
    protected ?string $username;
    protected ?string $password;

    public function __construct()
    {
        $this->ip = config('awtrix.ip');
        $this->port = config('awtrix.port');
        $this->username = config('awtrix.username');
        $this->password = config('awtrix.password');
    }

    /**
     * Send a notification to Awtrix device
     *
     * Usage examples:
     *   Awtrix::notify('my text')
     *   Awtrix::notify('my text', ['icon' => '87'])
     *   Awtrix::notify('my text', icon: '87')  // PHP 8 named parameters
     *
     * @param string $text The text to display
     * @param array $options Options: icon, duration, rainbow, hold, pushIcon, color, scrollSpeed
     * @return bool
     */
    public function notify(string $text, array $options = []): bool
    {
        $payload = array_merge([
            'text' => $text,
            'rainbow' => false,
            'icon' => '25596',
            'duration' => 15,
            'hold' => false,
            'pushIcon' => 2,
            'color' => '#FFFFFF',
            'scrollSpeed' => 100,
        ], $options);

        try {
            $http = Http::timeout(5);

            if ($this->username && $this->password) {
                $http->withBasicAuth($this->username, $this->password);
            }

            $response = $http->post("http://{$this->ip}:{$this->port}/api/notify", $payload);

            if ($response->successful()) {
                return true;
            }

            Log::error('Awtrix API error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return false;
        } catch (\Exception $e) {
            Log::error('Awtrix connection error', [
                'message' => $e->getMessage(),
            ]);

            return false;
        }
    }
}

