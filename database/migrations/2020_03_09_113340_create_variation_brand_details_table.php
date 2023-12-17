<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVariationBrandDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variation_brand_details', function (Blueprint $table) {
            $table->bigIncrements('id');


            $table->string('name')->nullable('Dummy');

            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id')->on('products')
                ->references('id')->onDelete('cascade');

            $table->unsignedBigInteger('product_variation_id')->nullable();
            $table->foreign('product_variation_id')->on('product_variations')
                ->references('id')->onDelete('cascade');

            $table->unsignedBigInteger('variation_id')->nullable();
            $table->foreign('variation_id')->on('variations')
                ->references('id')->onDelete('cascade');

            $table->unsignedBigInteger('brand_id')->nullable();
            $table->foreign('brand_id')->on('brands')
                ->references('id')->onDelete('cascade');

            $table->float('qty_available', 20, 4)->default(0);
            $table->float('retail_qty', 20, 4)->default(0);

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
        Schema::dropIfExists('variation_brand_details');
    }
}
