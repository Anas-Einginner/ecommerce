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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // معلومات أساسية
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            // التصنيف
            $table->foreignId('category_id')
                ->constrained()
                ->cascadeOnDelete();

            // الأسعار
            $table->decimal('price', 10, 2);
            $table->decimal('original_price', 10, 2)->nullable();

            // صورة المنتج
            $table->string('image')->nullable();

            // المخزون
            $table->integer('stock')->default(0);

            // إظهار / إخفاء المنتج
            $table->boolean('is_active')->default(true);

            // مميزات تسويقية (اختيارية)
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_on_sale')->default(false);
            $table->boolean('is_bestseller')->default(false);

            $table->timestamps();

            // Indexes لتحسين الأداء
            $table->index('category_id');
            $table->index('is_featured');
            $table->index('is_on_sale');
            $table->index('is_bestseller');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
