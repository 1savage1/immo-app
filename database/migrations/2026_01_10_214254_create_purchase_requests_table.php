<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 public function up(): void
{
    Schema::create('purchase_requests', function (Blueprint $table) {
        $table->id();

        // 🔹 المنزل المطلوب شراءه
        $table->foreignId('property_id')->constrained()->cascadeOnDelete();

        // 🔹 الشخص اللي طلب الشراء
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();

        // 🔹 حالة الطلب (موافقة/رفض/انتظار)
        $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_requests');
    }
};
