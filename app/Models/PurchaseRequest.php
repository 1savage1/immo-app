<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseRequest extends Model
{
    protected $fillable = [
        'property_id',
        'user_id',
        'status',
    ];

    // 🔹 الطلب تابع لمنزل
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    // 🔹 الطلب تابع للمستخدم الذي طلب الشراء
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
        

