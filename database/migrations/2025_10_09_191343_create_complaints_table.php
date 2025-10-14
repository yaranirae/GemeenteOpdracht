<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('complaint_number')->unique();  // رقم الشكوى (فريد)
            $table->string('category');                    // نوع المشكلة
            $table->string('address');                     // العنوان
            $table->text('description');                   // الوصف
            $table->decimal('latitude', 10, 8)->nullable(); // خط العرض
            $table->decimal('longitude', 11, 8)->nullable(); // خط الطول
            $table->foreignId('melder_id')->nullable()->constrained('melders'); // الربط بالمشتكي
            $table->string('photo_path')->nullable();      // مسار الصورة
            $table->string('status')->default('new');      // الحالة
            $table->timestamps();                          // التواريخ
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};