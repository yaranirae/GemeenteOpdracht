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
        Schema::create('melders', function (Blueprint $table) {
            $table->id(); // المعرف الأساسي
            $table->string('naam')->nullable(); // الاسم (اختياري)
            $table->string('email')->nullable()->unique(); // البريد الإلكتروني (اختياري وفريد)
            $table->string('mobiel')->nullable(); // رقم الهاتف (اختياري)
            $table->timestamps(); // created_at و updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('melders');
    }
};