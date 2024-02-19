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
        Schema::create('add_payment_id_to_order_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payment_id')->unsigned();
            $table->timestamps();
            $table->foreign('payment_id')->references('id')->on('payment_books')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('add_payment_id_to_order_details');
    }
};
