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
    Schema::create('property_images', function (Blueprint $table) {
        $table->id();

        // 🔹 الصورة تابعة لمنزل واحد
        $table->foreignId('property_id')->constrained()->cascadeOnDelete();

        // 🔹 مسار الصورة داخل storage أو public
        $table->string('path');

        // 🔹 ترتيب الصورة (1..10)
        $table->unsignedTinyInteger('position')->default(1);

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_images');
    }
};
