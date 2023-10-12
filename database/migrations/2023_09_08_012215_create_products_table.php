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
            $table->string('name');
            $table->string('description');
            $table->string('image')->nullable();
            $table->decimal('price');
            $table->integer('count');
            $table->integer('discount')->nullable();
            $table->foreignId('category_id')->references('id')->on('categories');
            $table->foreignId('brand_id')->nullable()->references('id')->on('brands');
            $table->foreignId('user_id')->references('id')->on('users');
            $table->enum('status',['active','pending'])->default('active');
            $table->integer('solded_out')->default(0);
            $table->integer('refunds')->default(0);
            $table->integer('total_gain')->default(0);
            $table->string('updated_by')->nullable();
            $table->softDeletes();
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
