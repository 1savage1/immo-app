<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail; // ✅ لإرسال الإيميلات

class InquiryController extends Controller
{
    /**
     * ✅ حفظ طلب شراء/كراء لعقار + إرسال Email للمالك
     */
    public function store(Request $request, Property $property)
    {
        // ✅ العقار لازم يكون approved باش يقدر الزبون يرسل طلب
        if ($property->status !== 'approved') {
            abort(404);
        }

        // ✅ 1) Validation (مبسّط)
        $validated = $request->validate([
            'type' => ['required', 'in:achat,location'],

            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],

            'message' => ['nullable', 'string'],

            // ✅ للكراء فقط
            'start_date' => ['nullable', 'date'],
            'end_date'   => ['nullable', 'date', 'after_or_equal:start_date'],
        ]);

        // ✅ 2) إنشاء الطلب
        $inquiry = Inquiry::create([
            'property_id' => $property->id,
            'user_id'     => $request->user()->id, // ✅ لأن route داخل auth

            'type'        => $validated['type'],
            'name'        => $validated['name'],
            'email'       => $validated['email'],
            'phone'       => $validated['phone'] ?? null,
            'message'     => $validated['message'] ?? null,

            'start_date'  => $validated['start_date'] ?? null,
            'end_date'    => $validated['end_date'] ?? null,

            'status'      => 'pending',
        ]);

        // ✅ 3) إرسال Email لصاحب العقار
        // ملاحظة: عندك owner_email في جدول properties (إيميل المالك الحقيقي)
        // إذا كان فارغ، نرجع لإيميل المستخدم اللي نشر الإعلان (owner في النظام)
        $property->loadMissing('user'); // ✅ نضمن user موجودة إذا نحتاجها

        $ownerEmail = $property->owner_email ?? ($property->user->email ?? null);

        if ($ownerEmail) {
            try {
                // ✅ عنوان الإيميل (فرنسي)
                $subject = "Nouvelle demande pour votre bien (ID: {$property->id})";

                // ✅ محتوى الإيميل (فرنسي) — بسيط وواضح
                $body = "Bonjour,\n\n"
                      . "Vous avez reçu une nouvelle demande pour votre bien:\n"
                      . "- Titre: {$property->title}\n"
                      . "- Type: " . ($inquiry->type === 'achat' ? 'Achat' : 'Location') . "\n"
                      . "- Nom: {$inquiry->name}\n"
                      . "- Email: {$inquiry->email}\n"
                      . "- Téléphone: " . ($inquiry->phone ?? 'Non indiqué') . "\n";

                // ✅ إذا كانت Location نضيف التواريخ
                if ($inquiry->type === 'location') {
                    $body .= "- Période: "
                          . ($inquiry->start_date ?? '---')
                          . " إلى "
                          . ($inquiry->end_date ?? '---')
                          . "\n";
                }

                $body .= "\nMessage:\n" . ($inquiry->message ?? 'Aucun message') . "\n\n"
                      . "Merci,\nImmoPlus";

                // ✅ إرسال Mail نصّي بسيط (بدون ملفات إضافية)
                Mail::raw($body, function ($message) use ($ownerEmail, $subject) {
                    $message->to($ownerEmail)
                            ->subject($subject);
                });

            } catch (\Throwable $e) {
                // ✅ إذا صرا مشكل في SMTP ما نحبسش الموقع
                report($e);
            }
        }

        // ✅ 4) نرجع المستخدم لصفحة التفاصيل برسالة نجاح
        return back()->with('success', '✅ Votre demande a été envoyée. Le propriétaire a été notifié par email.');
    }
}
