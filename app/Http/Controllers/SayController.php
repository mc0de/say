<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SayController extends Controller
{
    public function index()
    {
        return view('say');
    }

    public function submit(Request $request)
    {
        $text = $request->input('text');
        
        // You can process the text here
        // For now, we'll just return it back with a success message
        
        return back()->with('success', 'Text submitted: ' . $text);
    }
}

