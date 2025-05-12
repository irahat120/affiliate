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
        Schema::create('admin_products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->string('sku');
            $table->string('description');
            $table->integer('categories_id')->unsigned(); 
            $table->foreign('categories_id')->references('id')->on('categories');
            $table->string('image');
            $table->integer('buy_price')->nullable();
            $table->integer('sell_price')->nullable()->default(0);
            $table->string('brand');
            $table->json('tags');
            $table->integer('total_sell')->default(0);
            $table->integer('stock')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_products');
    }
};
