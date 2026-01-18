<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
{
    Schema::create('properties', function (Blueprint $table) {
        $table->id();

        // 🔹 صاحب الإعلان (الشخص اللي أضاف المنزل للموقع)
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();

        // 🔹 بيانات صاحب المنزل الحقيقي (للتواصل + إرسال الإيميل)
        $table->string('owner_email');
        $table->string('owner_phone')->nullable();

        // 🔹 نوع العملية: بيع أو كراء
        $table->enum('operation', ['vente', 'location']); // بالفرنسية كما طلبت

        // 🔹 نوع العقار: شقة / فيلا / ستوديو
        $table->enum('category', ['appartement', 'villa', 'studio']);

        // 🔹 معلومات أساسية
        $table->string('title');          // عنوان قصير
        $table->text('description');      // وصف
        $table->string('city');           // المكان (مثلا Alger, Oran...)
        $table->integer('rooms');         // عدد الغرف
        $table->integer('area');          // المساحة بالمتر
        $table->bigInteger('price');      // السعر بالدينار DA

        // 🔹 حالة الموافقة من الأدمن
        $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');

        // 🔹 عداد عدد مرات كراء المنزل (للأدمن فقط)
        $table->unsignedInteger('rent_count')->default(0);

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
