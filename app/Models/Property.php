<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    /**
     * ✅ الحقول المسموح تعبئتها (Mass Assignment)
     * نخليها شاملة للحقول اللي عندك في migration تاع properties.
     */
    protected $fillable = [
        'user_id',

        // ✅ معلومات المالك الحقيقي للتواصل
        'owner_email',
        'owner_phone',

        // ✅ نوع العملية + نوع العقار
        'operation',   // vente / location
        'category',    // appartement / villa / studio

        // ✅ معلومات الإعلان
        'title',
        'description',
        'city',
        'rooms',
        'area',
        'price',

        // ✅ حالة الإعلان
        'status',      // pending / approved / rejected

        // ✅ عداد مرات الكراء (للأدمن)
        'rent_count',
    ];

    /**
     * ✅ صاحب الإعلان (المستخدم الذي أضاف العقار)
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    /**
     * ✅ صور العقار
     */
    public function images()
    {
        return $this->hasMany(\App\Models\PropertyImage::class);
    }

    /**
     * ✅ حجوزات/عدم التوفر (للـ location)
     */
    public function bookings()
    {
        return $this->hasMany(\App\Models\Booking::class);
    }

    /**
     * ✅ طلبات الشراء (إن كنت تستعمل جدول purchase_requests)
     */
    public function purchaseRequests()
    {
        return $this->hasMany(\App\Models\PurchaseRequest::class);
    }

    /**
     * ✅ الطلبات (شراء/كراء) الجديدة (inquiries)
     */
    public function inquiries()
    {
        return $this->hasMany(\App\Models\Inquiry::class);
    }
}
