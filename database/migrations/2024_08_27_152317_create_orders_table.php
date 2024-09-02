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
            $table->foreignId('userId')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('address');
            $table->foreignId('cityId')->references('id')->on('cities')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('provinceId')->references('id')->on('provinces')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('zip_code');
            $table->integer('total_price');
            $table->string('token')->nullable();
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
