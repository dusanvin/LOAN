<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

     // Stelle sicher, dass 'group' in der fillable-Eigenschaft enthalten ist
     protected $fillable = [
        'name',
        'description',
        'group', // Füge diese Zeile hinzu
        // weitere Eigenschaften
    ];


}
