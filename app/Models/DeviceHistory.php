<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceHistory extends Model
{
    use HasFactory;

    protected $fillable = ['device_id', 'action', 'user_name', 'action_by'];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
