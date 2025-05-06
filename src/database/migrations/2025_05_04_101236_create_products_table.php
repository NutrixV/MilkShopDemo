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
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 8, 2);
            $table->string('image_path')->nullable();
            $table->boolean('in_stock')->default(true);
            $table->string('fat_content')->nullable();
            $table->integer('volume')->nullable();
            $table->string('unit', 10)->default('ml');
            $table->date('expiration_date')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('storage_temp')->nullable();
            $table->boolean('is_organic')->default(false);
            $table->timestamps();
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
