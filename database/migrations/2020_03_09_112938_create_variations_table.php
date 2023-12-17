<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVariationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variations', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name')->nullable('Dummy');

            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id')->on('products')
                ->references('id')->onDelete('cascade');

            $table->string('sub_sku')->nullable();

            $table->unsignedBigInteger('product_variation_id')->nullable();
            $table->foreign('product_variation_id')->on('product_variations')
                ->references('id')->onDelete('cascade');

            $table->unsignedBigInteger('variation_value_id')->nullable();
            $table->foreign('variation_value_id')->on('variation_template_details')
                ->references('id')->onDelete('set null');

            $table->unsignedBigInteger('variation_value_id_2')->nullable();
            $table->foreign('variation_value_id_2')->on('variation_template_details')
                ->references('id')->onDelete('set null');

            $table->unsignedBigInteger('variation_value_id_3')->nullable();
            $table->foreign('variation_value_id_3')->on('variation_template_details')
                ->references('id')->onDelete('set null');

            $table->unsignedBigInteger('variation_value_id_4')->nullable();
            $table->foreign('variation_value_id_4')->on('variation_template_details')
                ->references('id')->onDelete('set null');

            $table->unsignedBigInteger('variation_value_id_5')->nullable();
            $table->foreign('variation_value_id_5')->on('variation_template_details')
                ->references('id')->onDelete('set null');

            $table->float('default_purchase_price', 20, 4)->default(0);
            $table->float('profit_percent', 20, 4)->default(0);
            $table->float('default_sell_price', 20, 4)->default(0);
            $table->float('retail_sell_price', 20, 4)->default(0);
            $table->boolean('hidden')->default(0);
            $table->longText('tek_marks')->nullable();

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
        Schema::dropIfExists('variations');
    }
}
