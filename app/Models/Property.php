<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    // ✅ الأعمدة اللي نسمح بالتعبئة الجماعية لها (Mass Assignment)
    protected $fillable = [
        'user_id',
        'owner_email',
        'owner_phone',
        'operation',
        'category',
        'title',
        'description',
        'city',
        'rooms',
        'area',
        'price',
        'status',
        'rent_count',
    ];

    // 🔹 المنزل تابع لمستخدم (الذي أضاف الإعلان)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 🔹 المنزل عنده عدة صور
    public function images()
    {
        return $this->hasMany(PropertyImage::class);
    }

    // 🔹 المنزل عنده عدة حجوزات (عدم التوفر)
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // 🔹 المنزل عنده عدة طلبات شراء
    public function purchaseRequests()
    {
        return $this->hasMany(PurchaseRequest::class);
    }
}

