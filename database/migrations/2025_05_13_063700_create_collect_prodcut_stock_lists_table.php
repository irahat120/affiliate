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
        Schema::create('collect_product_stock_lists', function (Blueprint $table) {
            $table->id();
            $table->integer('unique_number');
            $table->foreignId('collect_product_stock_id')->constrained();
            $table->foreignId('admin_product_id')->constrained();
            $table->integer('buy_price');
            $table->string('collection_user')->default('admin');
            $table->string('stock_status')->default('Instock');
            $table->string('Order_number')->nullable();
            $table->string('track_number')->nullable();
            $table->string('packing_user')->nullable();
            $table->string('packing_time')->nullable();
            $table->string('droaping_user')->nullable();
            $table->string('droaping_time')->nullable();
            $table->string('return_user')->nullable();
            $table->string('return_time')->nullable();
            $table->string('return_confirm_status')->nullable();
            $table->string('return_confirm_user')->nullable();
            $table->string('return_confirm_time')->nullable();
            $table->string('sell_price')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collect_prodcut_stock_lists');
    }
};
