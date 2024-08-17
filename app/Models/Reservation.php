<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = ['room_id', 'user_id', 'start_date', 'end_date'];

    // Beziehung zur Room-Tabelle
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    // Beziehung zur User-Tabelle
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
