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
    Schema::create('bookings', function (Blueprint $table) {
        $table->id();

        // 🔹 المنزل المحجوز
        $table->foreignId('property_id')->constrained()->cascadeOnDelete();

        // 🔹 الشخص اللي قام بالحجز
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();

        // 🔹 تاريخ البداية + عدد الأيام
        $table->date('start_date');
        $table->unsignedInteger('days');

        // 🔹 تاريخ النهاية (نخزنه باش نسهل التحقق من التداخل)
        $table->date('end_date');

        // 🔹 حالة الحجز (لا يصبح فعّال إلا بعد موافقة الأدمن)
        $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
