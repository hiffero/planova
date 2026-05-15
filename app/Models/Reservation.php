<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model {
    protected $fillable = [
        'user_id', 'cafe_id', 'reservation_date', 
        'reservation_time', 'guests', 'notes', 
        'payment_proof', 'status'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function cafe() {
        return $this->belongsTo(Cafe::class);
    }
}