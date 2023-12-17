<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductVariationTemplateDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variation_template_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_variation_template_id')->nullable();
            $table->foreign('product_variation_template_id', 'pvt_id')->on('product_variation_templates')->references('id')->onDelete('Cascade');
            $table->unsignedBigInteger('variation_template_id')->nullable();
            $table->foreign('variation_template_id', 'vt_id')->on('variation_templates')->references('id')->onDelete('Cascade');
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
        Schema::dropIfExists('product_variation_template_details');
    }
}
