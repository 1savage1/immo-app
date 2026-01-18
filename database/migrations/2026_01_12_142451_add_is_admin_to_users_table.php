<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // ✅ عمود يحدد هل المستخدم أدمن أم لا
            // false = مستخدم عادي ، true = أدمن
            $table->boolean('is_admin')->default(false)->after('password');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // ✅ حذف العمود إذا رجعنا للخلف
            $table->dropColumn('is_admin');
        });
    }
};
