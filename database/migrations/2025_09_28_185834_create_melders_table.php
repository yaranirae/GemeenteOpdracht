<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('melders', function (Blueprint $table) {
            $table->id();
            $table->string('naam');
            $table->string('email')->nullable();
            $table->string('mobiel')->nullable();
            $table->timestamps();
        });

        // تحديث جدول الشكاوى لإضافة العلاقة
        Schema::table('complaints', function (Blueprint $table) {
            $table->foreignId('melder_id')->nullable()->constrained('melders')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->dropForeign(['melder_id']);
            $table->dropColumn('melder_id');
        });
        
        Schema::dropIfExists('melders');
    }
};