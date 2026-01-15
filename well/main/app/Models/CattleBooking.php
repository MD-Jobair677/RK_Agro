<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CattleBooking extends Model
{
    use HasFactory;


    public function cattle()
    {
        return $this->belongsTo(Cattle::class, 'cattle_id', 'id');
    }

     public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
