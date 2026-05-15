<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cafe extends Model {
    protected $fillable = [
        'name', 'description', 'address', 'image'
    ];

    public function menus() { 
        return $this->hasMany(Menu::class); 
    }

    public function reservations() { 
        return $this->hasMany(Reservation::class); 
    }
}
