<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    // Diese Felder dürfen per Massenverarbeitung (Mass Assignment) gesetzt werden
    protected $fillable = [
        'room_id', 
        'user_id', 
        'start_date', 
        'end_date', 
        'start_time', 
        'end_time',
        'purpose', // Füge das 'purpose'-Feld hier hinzu
    ];

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
