<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        // ✅ WAJIB: Load nested relation 'cafe.menus'
        $query = Reservation::with(['user', 'cafe.menus']);
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('user', fn($q) => $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%"))
                ->orWhereHas('cafe', fn($q) => $q->where('name', 'LIKE', "%{$search}%"));
            });
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $reservations = $query->latest()->paginate(15)->withQueryString();
        
        return view('admin.reservations.index', compact('reservations'));
    }

    public function updateStatus(Request $request, Reservation $reservation)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected'
        ]);
        
        $reservation->update(['status' => $request->status]);
        
        return back()->with('success', "Status reservasi #{$reservation->id} berhasil di-{$request->status}!");
    }
}