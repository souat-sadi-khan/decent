<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkOrderDeliveryItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_order_delivery_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('work_order_deliveries_id')->nullable();
            $table->foreign('work_order_deliveries_id')->on('work_order_deliveries')->references('id')->onDelete('cascade');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id')->on('products')->references('id')->onDelete('cascade');
            $table->unsignedBigInteger('variation_id')->nullable();
            $table->foreign('variation_id')->on('variations')->references('id')->onDelete('cascade');
            $table->double('quantity',2)->nullable();
            $table->string('date')->nullable();
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
        Schema::dropIfExists('work_order_delivery_items');
    }
}
