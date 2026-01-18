<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'property_id',
        'user_id',
        'start_date',
        'days',
        'end_date',
        'status',
    ];

    // 🔹 الحجز تابع لمنزل
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    // 🔹 الحجز تابع للمستخدم الذي قام بالحجز
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
