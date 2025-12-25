<?php

namespace App\Http\Controllers;

use App\Facades\Awtrix;
use Illuminate\Http\Request;

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

        $success = Awtrix::notify($text, [
            'icon' => '25596',
            'duration' => 15,
            'color' => '#FFFFFF',
        ]);

        if ($success) {
            return back()->with('success', 'Message sent to Awtrix!');
        }

        return back()->with('error', 'Failed to send message to Awtrix.');
    }
}
