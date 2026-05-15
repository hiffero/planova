<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cafe;
use App\Models\Reservation;

class ReservationController extends Controller {
    public function create() {
        $cafes = \App\Models\Cafe::all();
        return view('reservations.create', compact('cafes'));
    }
    public function store(Request $request) {
        $validated = $request->validate([
            'cafe_id' => 'required|exists:cafes,id',
            'reservation_date' => 'required|date|after:today',
            'reservation_time' => 'required',
            'guests' => 'required|integer|min:1',
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('payment_proof')) {
            $validated['payment_proof'] = $request->file('payment_proof')->store('payments', 'public');
        }

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'pending';
        \App\Models\Reservation::create($validated);

        return redirect()->route('reservations.index')->with('success', 'Reservasi berhasil dikirim. Menunggu konfirmasi admin.');
    }
    public function index() {
        $reservations = \App\Models\Reservation::where('user_id', auth()->id())->with('cafe')->latest()->get();
        return view('reservations.index', compact('reservations'));
    }
}