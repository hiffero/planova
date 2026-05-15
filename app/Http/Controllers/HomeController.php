<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        $cafes = \App\Models\Cafe::latest()->get();
        return view('welcome', compact('cafes'));
    }
    public function dashboard() {
        return auth()->user()->role === 'admin' 
            ? redirect()->route('admin.dashboard') 
            : redirect()->route('reservations.create');
    }
}
