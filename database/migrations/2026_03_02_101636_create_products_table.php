<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            // Khóa ngoại liên kết với bảng categories
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('name');
            $table->decimal('price', 15, 2); // Giá bán thường (15 số, 2 số thập phân)
            $table->decimal('sale_price', 15, 2)->nullable(); // Giá khuyến mãi
            $table->integer('stock')->default(0); // Số lượng tồn kho
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(1);
            $table->boolean('is_delete')->default(0); // Cờ xóa mềm
            $table->timestamps();

            // Ràng buộc khóa ngoại
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};