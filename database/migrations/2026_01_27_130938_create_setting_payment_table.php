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
        Schema::create('setting_payment', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // اسم الإعداد مثل stripe_public_key
            $table->text('value')->nullable(); // القيمة
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setting_payment');
    }
};
