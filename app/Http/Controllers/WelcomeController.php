<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\View\View;

class WelcomeController extends Controller
{
    public function index(Request $request): View
    {
        $message = $request->session()->get('message');
        return view('welcome', compact('message'));
    }
}
