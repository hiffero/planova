<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cafe extends Model
{
    protected $fillable = [
        'name',
        'description',
        'address',
        'image',
    ];

    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class);
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }
}