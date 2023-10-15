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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_serial_code');
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('address_id')->nullable()->references('id')->on('addresses');
            $table->enum('status',['pending','in_progress','delivered','shipped','refunded']);
            $table->integer('total_price')->nullable();
            $table->string('transactionId')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
