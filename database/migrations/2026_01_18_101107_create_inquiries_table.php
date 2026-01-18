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
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();

            // ✅ الطلب مرتبط بعقار
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();

            // ✅ صاحب الطلب (المستخدم اللي راهو مسجل دخول) - نخليها nullable احتياط
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            // ✅ نوع الطلب: شراء أو كراء
            $table->enum('type', ['achat', 'location']);

            // ✅ معلومات الزبون (باش نخليها بسيطة ومضمونة)
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();

            // ✅ رسالة اختيارية
            $table->text('message')->nullable();

            // ✅ للكراء فقط: فترة الكراء
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            // ✅ حالة الطلب (لاحقاً الأدمن يقدر يوافق/يرفض)
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
