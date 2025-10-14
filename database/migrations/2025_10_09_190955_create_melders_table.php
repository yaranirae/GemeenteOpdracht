<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('melders', function (Blueprint $table) {
            $table->id();
            $table->string('naam')->nullable();       // الاسم (اختياري)
            $table->string('email')->nullable();      // البريد الإلكتروني (اختياري)
            $table->string('mobiel')->nullable();     // رقم الهاتف (اختياري)
            $table->timestamps();                     // created_at و updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('melders');
    }
};