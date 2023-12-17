<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApproveStoreItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approve_store_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('depertment_id')->nullable();
            $table->unsignedBigInteger('store_request_id')->nullable();
            $table->unsignedBigInteger('work_order_id')->nullable();
            $table->unsignedBigInteger('raw_material_id')->nullable();
            $table->string('qty')->nullable();
            $table->string('approve_date')->nullable();
            $table->string('status')->nullable();
            $table->text('note')->nullable();
            $table->boolean('hidden')->default(0);
            $table->longText('tek_marks')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->foreign('depertment_id')->references('id')->on('depertments')->onDelete('cascade');
            $table->foreign('store_request_id')->references('id')->on('store_requests')->onDelete('cascade');
            $table->foreign('work_order_id')->references('id')->on('work_orders')->onDelete('cascade');
            $table->foreign('raw_material_id')->references('id')->on('raw_materials')->onDelete('cascade');
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
        Schema::dropIfExists('approve_store_items');
    }
}
