<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductFlowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_flows', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('depertment_id')->nullable();
            $table->integer('send_depertment_id')->nullable();
            $table->unsignedBigInteger('variation_id')->nullable();
            $table->foreign('variation_id')->on('variations')
                ->references('id')->onDelete('cascade');
            $table->unsignedBigInteger('work_order_id')->nullable();
            $table->foreign('work_order_id')->references('id')->on('work_orders')->onDelete('cascade');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->string('qty')->nullable();
            $table->text('note')->nullable();
            $table->text('date')->nullable();
            $table->integer('done_depertment_id')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamp('deleted_at')->nullable();
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
        Schema::dropIfExists('product_flows');
    }
}
