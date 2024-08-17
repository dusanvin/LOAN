<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'location', 'new_column']; // 'new column' durch 'new_column' ersetzt

    // Beziehung zur Reservation-Tabelle
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
