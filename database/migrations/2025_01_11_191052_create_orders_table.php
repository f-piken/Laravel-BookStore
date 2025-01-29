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
            $table->foreignId('seller_id')->constrained('sellers')->onDelete('cascade'); 
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade'); 
            $table->foreignId('delivery_option_id')->constrained('delivery_options')->onDelete('cascade'); 
            $table->string('order_number')->unique();
            $table->decimal('subtotal', 15, 2);
            $table->decimal('tax', 15, 2);
            $table->decimal('total_amount', 15, 2);
            $table->string('status')->default('pending'); // e.g., pending, completed, cancelled
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
