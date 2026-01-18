<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    // ✅ الحقول اللي نسمح بحفظها مباشرة
    protected $fillable = [
        'property_id',
        'user_id',
        'type',
        'name',
        'email',
        'phone',
        'message',
        'start_date',
        'end_date',
        'status',
    ];

    /**
     * ✅ الطلب تابع لعقار واحد
     */
    public function property()
    {
        // ✅ استعمال المسار الكامل باش ما يبقاش error في VS Code
        return $this->belongsTo(\App\Models\Property::class);
    }

    /**
     * ✅ الطلب تابع لمستخدم واحد (الزبون)
     */
    public function user()
    {
        // ✅ استعمال المسار الكامل باش ما يبقاش error
        return $this->belongsTo(\App\Models\User::class);
    }
}
