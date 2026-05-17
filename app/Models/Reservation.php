<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    protected $fillable = [
        'user_id',
        'cafe_id',
        'reservation_date',
        'reservation_time',
        'guests',
        'notes',
        'payment_proof',
        'status',
        'selected_menus', // ✅ WAJIB: Tambahkan ini agar data tersimpan
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cafe(): BelongsTo
    {
        return $this->belongsTo(Cafe::class);
    }
}