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
        Schema::table('payment_books', function (Blueprint $table) {
            $table->string('order_id')->nullable()->before('user_id');
            $table->string('stripe_transaction_id')->nullable()->before('order_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_books', function (Blueprint $table) {
            $table->dropColumn('order_id');
            $table->dropColumn('stripe_transaction_id');
        });
    }
};
