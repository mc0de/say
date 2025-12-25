<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SayController extends Controller
{
    public function index()
    {
        return view('say');
    }

    public function submit(Request $request)
    {
        $request->validate([
            'text' => 'required|string|max:255',
        ]);

        $text = $request->input('text');

        // Get Awtrix configuration from environment
        $awtrixIp   = config('awtrix.ip');
        $awtrixPort = config('awtrix.port');

        // Prepare payload for Awtrix 3 API
        $payload = [
            'text'        => $text,
            'rainbow'     => false,
            'icon'        => '25596', // Default icon, can be customized
            'duration'    => 15, // Duration in seconds
            'hold'        => false,
            'pushIcon'    => 2, // Icon position
            'color'       => '#FFFFFF',
            'scrollSpeed' => 100,
        ];

        try {
            // Send to Awtrix via HTTP POST
            $response = Http::withBasicAuth(config('awtrix.username'), config('awtrix.password'))
                ->timeout(5)
                ->post("http://{$awtrixIp}:{$awtrixPort}/api/notify", $payload);

            if ($response->successful()) {
                return back()->with('success', 'Message sent to Awtrix!');
            } else {
                Log::error('Awtrix API error', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);

                return back()->with('error', 'Failed to send message to Awtrix.');
            }
        } catch (\Exception $e) {
            Log::error('Awtrix connection error', [
                'message' => $e->getMessage(),
            ]);

            return back()->with('error', 'Could not connect to Awtrix device.');
        }
    }
}
