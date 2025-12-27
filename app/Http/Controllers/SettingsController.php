<?php

namespace App\Http\Controllers;

use App\Facades\Awtrix;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings');
    }

    public function store(Request $request)
    {
        $request->validate([
            'color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
        ]);

        // Store the color value (you can save it to database, config, etc.)
        $color = $request->input('color');

        Awtrix::globalTextColor($color);

        return redirect()->route('settings.index')->with('success', "Color {$color} saved successfully!");
    }
}
