<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // ✅ لاستعمال Auth::id() بشكل واضح

class PropertyController extends Controller
{
    /**
     * ✅ الصفحة الرئيسية: تعرض كل العقارات الموافق عليها فقط
     */
    public function index(Request $request)
    {
        $properties = Property::where('status', 'approved')
            ->with(['images']) // ✅ تحميل الصور لتفادي N+1
            ->latest()
            ->paginate(9);

        return view('properties.index', compact('properties'));
    }

    /**
     * ✅ صفحة البيع: تعرض العقارات للبيع فقط (approved)
     */
    public function vente()
    {
        $properties = Property::where('status', 'approved')
            ->where('operation', 'vente')
            ->with(['images'])
            ->latest()
            ->paginate(9);

        return view('properties.vente', compact('properties'));
    }

    /**
     * ✅ صفحة الكراء: تعرض العقارات للكراء فقط (approved)
     */
    public function location()
    {
        $properties = Property::where('status', 'approved')
            ->where('operation', 'location')
            ->with(['images'])
            ->latest()
            ->paginate(9);

        return view('properties.location', compact('properties'));
    }

    /**
     * ✅ صفحة تفاصيل عقار واحد
     */
    public function show(Property $property)
    {
        // ✅ إذا العقار ماشي approved، ما يبانش للناس
        if ($property->status !== 'approved') {
            abort(404);
        }

        // ✅ نحمّل الصور + الحجوزات الموافق عليها فقط
        $property->load([
            'images',
            'bookings' => function ($q) {
                // ✅ الحجوزات الموافق عليها فقط لأنها تعني "غير متاح"
                $q->where('status', 'approved')->orderBy('start_date');
            }
        ]);

        return view('properties.show', compact('property'));
    }

    /**
     * ✅ صفحة فورم إضافة عقار (محميّة بـ middleware في routes/web.php)
     */
    public function create()
    {
        return view('properties.create');
    }

    /**
     * ✅ حفظ عقار جديد + رفع الصور (حتى 10 صور)
     */
    public function store(Request $request)
    {
        // ✅ ملاحظة مهمة:
        // routes/web.php راهو حامي هذا route بـ middleware('auth')
        // يعني المستخدم لازم يكون مسجل دخول هنا

        // ✅ 1) Validation
        $validated = $request->validate([
            // 🔹 معلومات صاحب العقار الحقيقي (اختيارية)
            'owner_email' => ['nullable', 'email'],
            'owner_phone' => ['nullable', 'string', 'max:30'],

            // 🔹 معلومات العقار الأساسية
            'operation'   => ['required', 'in:vente,location'],
            'category'    => ['required', 'in:appartement,villa,studio'],
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'city'        => ['required', 'string', 'max:255'],
            'rooms'       => ['required', 'integer', 'min:0', 'max:50'],
            'area'        => ['required', 'integer', 'min:1', 'max:10000'],
            'price'       => ['required', 'numeric', 'min:0'],

            // 🔹 الصور (اختيارية) - حتى 10 صور
            'images'      => ['nullable', 'array', 'max:10'],
            'images.*'    => ['image', 'mimes:jpg,jpeg,png,webp', 'max:4096'], // 4MB
        ]);

        // ✅ 2) إنشاء العقار بطريقة بسيطة (بدون Mass Assignment لتفادي أخطاء fillable)
        $property = new Property();

        // ✅ user_id مضمون لأن المستخدم مسجل دخول (auth middleware)
        $property->user_id = $request->user()->id;

        // 🔹 معلومات صاحب العقار الحقيقي (اختيارية)
        $property->owner_email = $validated['owner_email'] ?? null;
        $property->owner_phone = $validated['owner_phone'] ?? null;

        // 🔹 معلومات العقار
        $property->operation   = $validated['operation'];
        $property->category    = $validated['category'];
        $property->title       = $validated['title'];
        $property->description = $validated['description'];
        $property->city        = $validated['city'];
        $property->rooms       = $validated['rooms'];
        $property->area        = $validated['area'];
        $property->price       = $validated['price'];

        // ✅ التعديل المهم: أي عقار جديد لازم يكون Pending (في انتظار موافقة الأدمن)
        // ✅ هذا يضمن ما يبانش في الصفحة الرئيسية حتى يوافق عليه الأدمن
        $property->status = 'pending';

        $property->save();

        // ✅ 3) رفع الصور (إن وجدت)
        if ($request->hasFile('images')) {

            $position = 1; // 🔹 ترتيب الصور 1..10

            foreach ($request->file('images') as $img) {

                // ✅ نخزن الصورة داخل: storage/app/public/properties
                // ويرجع مسار مثل: properties/xxxx.webp
                $path = $img->store('properties', 'public');

                // ✅ نسجل الصورة في جدول property_images (بدون Mass Assignment)
                $propertyImage = new PropertyImage();
                $propertyImage->property_id = $property->id;
                $propertyImage->path = $path;       // ✅ اسم العمود path
                $propertyImage->position = $position;
                $propertyImage->save();

                $position++;
            }
        }

        // ✅ 4) رجّع المستخدم للصفحة الرئيسية برسالة
        // لأن صفحة التفاصيل تمنع pending (تعطي 404)
        return redirect()
            ->route('home')
            ->with('success', '✅ تم إرسال الإعلان للمراجعة. سيتم نشره بعد الموافقة.');
    }

    /**
     * ✅ صفحة "إعلاناتي": تعرض كل عقارات المستخدم الحالي (حتى pending)
     */
    public function mine()
    {
        // ✅ هذه الصفحة محمية بـ auth middleware من routes/web.php
        // لذلك Auth::id() دائما ترجع رقم (ماشي null)

        $properties = Property::where('user_id', Auth::id()) // ✅ عقارات المستخدم الحالي فقط
            ->with(['images'])
            ->latest()
            ->paginate(9);

        return view('properties.mine', compact('properties'));
    }
}
