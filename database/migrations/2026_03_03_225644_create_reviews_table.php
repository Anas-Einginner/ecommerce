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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
                $table->string('name');
                
                $table->string('email');

                $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();

                $table->integer('rating');

                $table->string('title');

                $table->text('review');

                $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
