<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductVariationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variations', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('variation_template_id')->nullable();
            $table->foreign('variation_template_id')->on('variation_templates')
                ->references('id')->onDelete('cascade');

            $table->unsignedBigInteger('variation_template_id_2')->nullable();
            $table->foreign('variation_template_id_2')->on('variation_templates')
                ->references('id')->onDelete('cascade');

            $table->unsignedBigInteger('variation_template_id_3')->nullable();
            $table->foreign('variation_template_id_3')->on('variation_templates')
                ->references('id')->onDelete('cascade');


            $table->unsignedBigInteger('variation_template_id_4')->nullable();
            $table->foreign('variation_template_id_4')->on('variation_templates')
                ->references('id')->onDelete('cascade');



            $table->unsignedBigInteger('variation_template_id_5')->nullable();
            $table->foreign('variation_template_id_5')->on('variation_templates')
                ->references('id')->onDelete('cascade');

            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id')->on('products')
                ->references('id')->onDelete('cascade');

            $table->boolean('is_dummy')->default(1);
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
        Schema::dropIfExists('product_variations');
    }
}
