<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReservationController extends Controller
{
    public function create()
    {
        // ✅ WAJIB: Load menus untuk setiap cafe
        $cafes = \App\Models\Cafe::with('menus')->get();
        
        // Debug log
        Log::info('Loading cafes for reservation', [
            'cafes_count' => $cafes->count(),
            'cafes' => $cafes->map(fn($c) => [
                'id' => $c->id,
                'name' => $c->name,
                'menus_count' => $c->menus->count()
            ])
        ]);
        
        return view('reservations.create', compact('cafes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cafe_id' => 'required|exists:cafes,id',
            'reservation_date' => 'required|date|after:today',
            'reservation_time' => 'required',
            'guests' => 'required|integer|min:1|max:50',
            'selected_menus' => 'nullable', // Biarkan fleksibel
            'notes' => 'nullable|string|max:500',
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Upload bukti pembayaran
        if ($request->hasFile('payment_proof')) {
            $validated['payment_proof'] = $request->file('payment_proof')->store('payments', 'public');
        }

        // ✅ LOGIKA PENYIMPANAN MENU YANG AMAN
        $rawMenus = $request->input('selected_menus');
        
        if (!empty($rawMenus)) {
            // Jika input sudah berupa array, convert ke JSON string
            if (is_array($rawMenus)) {
                $validated['selected_menus'] = json_encode($rawMenus);
            } 
            // Jika input adalah string JSON, biarkan saja
            elseif (is_string($rawMenus)) {
                $validated['selected_menus'] = $rawMenus;
            } 
            // Fallback jika format tidak dikenali
            else {
                $validated['selected_menus'] = json_encode([$rawMenus]);
            }
        } else {
            $validated['selected_menus'] = json_encode([]);
        }

        // Simpan data
        $reservation = Reservation::create([
            'user_id' => auth()->id(),
            'cafe_id' => $validated['cafe_id'],
            'reservation_date' => $validated['reservation_date'],
            'reservation_time' => $validated['reservation_time'],
            'guests' => $validated['guests'],
            'selected_menus' => $validated['selected_menus'], // ✅ Pastikan ini dikirim
            'notes' => $validated['notes'] ?? null,
            'payment_proof' => $validated['payment_proof'],
            'status' => 'pending',
        ]);

        return redirect()->route('reservations.index')
            ->with('success', 'Reservasi berhasil dikirim!');
    }

    public function index()
    {
        $reservations = Reservation::with(['user', 'cafe.menus'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();
        
        return view('reservations.index', compact('reservations'));
    }
}