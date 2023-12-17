<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecialOfferItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('special_offer_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('special_offer_id')->nullable();
            $table->foreign('special_offer_id')->on('special_offers')->references('id')->onDelete('cascade');
            $table->unsignedBigInteger('variation_id')->nullable();
            $table->foreign('variation_id')->on('variations')->references('id')->onDelete('cascade');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id')->on('products')->references('id')->onDelete('cascade');
            $table->string('discount_type')->nullable();
            $table->double('discount_amount', 2)->nullable();
            $table->double('price_without_dis')->nullable();
            $table->double('price_with_dis')->nullable();
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
        Schema::dropIfExists('special_offer_items');
    }
}
