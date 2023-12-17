<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEcommerceProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ecommerce_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id')->on('products')->references('id')->onDelete('cascade');
            $table->unsignedBigInteger('product_variation_id')->nullable();
            $table->foreign('product_variation_id')->on('product_variations')->references('id')->onDelete('cascade');
            $table->unsignedBigInteger('variation_id')->nullable();
            $table->foreign('variation_id')->on('variations')->references('id')->onDelete('cascade');
            $table->double('quantity', 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ecommerce_products');
    }
}
