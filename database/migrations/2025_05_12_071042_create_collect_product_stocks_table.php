<?php

use Doctrine\DBAL\Schema\Table;
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
        Schema::create('collect_product_stocks', function (Blueprint $table) {
            $table->id();
            $table->string('unique_number');
            $table->foreignId('admin_product_id')->constrained();
            $table->integer('quantity')->nullable()->default(0);
            $table->integer('paid_price')->nullable()->default(0);
            $table->string('collection_user')->default('admin');
            $table->string('stock')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collect_product_stocks');
    }
};
