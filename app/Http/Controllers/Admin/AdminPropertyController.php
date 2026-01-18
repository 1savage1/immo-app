<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;

class AdminPropertyController extends Controller
{
    /**
     * ✅ عرض العقارات اللي في انتظار الموافقة
     */
    public function pending()
    {
        $properties = Property::where('status', 'pending')
            ->latest()
            ->paginate(10);

        return view('admin.properties.pending', compact('properties'));
    }

    /**
     * ✅ موافقة الأدمن على العقار
     */
    public function approve(Property $property)
    {
        $property->update(['status' => 'approved']);

        return back()->with('success', 'Bien approuvé ✅');
    }

    /**
     * ✅ رفض العقار
     */
    public function reject(Property $property)
    {
        $property->update(['status' => 'rejected']);

        return back()->with('success', 'Bien rejeté ✅');
    }
}
