<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image')->nullable(); // Cho phép null
            $table->unsignedBigInteger('parent_id')->nullable(); // Self-reference
            $table->boolean('is_active')->default(1);
            $table->boolean('is_delete')->default(0); // Soft delete kiểu boolean
            $table->timestamps();

            // Tạo khóa ngoại tham chiếu đến chính bảng này
            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};