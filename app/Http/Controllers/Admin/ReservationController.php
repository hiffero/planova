<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $query = Reservation::with(['user', 'cafe']);
        
        // 🔍 Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('user', fn($q) => $q->where('name', 'LIKE', "%{$search}%"))
                  ->orWhereHas('cafe', fn($q) => $q->where('name', 'LIKE', "%{$search}%"));
            });
        }
        
        // 🏷️ Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // ✅ PAGINATE (bukan get!)
        $reservations = $query->latest()->paginate(15)->withQueryString();
        
        return view('admin.reservations.index', compact('reservations'));
    }

    public function updateStatus(Request $request, Reservation $reservation)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected'
        ]);
        
        $reservation->update(['status' => $request->status]);
        
        return back()->with('success', 
            "Reservasi #{$reservation->id} berhasil di-{$request->status}!"
        );
    }
}