<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseReceivedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_receiveds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('transaction_id')->nullable();
            $table->foreign('transaction_id')->on('transactions')->references('id')->onDelete('cascade');
            $table->unsignedBigInteger('purchase_id')->nullable();
            $table->foreign('purchase_id')->on('purchases')->references('id')->onDelete('cascade');
            $table->unsignedBigInteger('raw_material_id')->nullable();
            $table->foreign('raw_material_id')->on('raw_materials')->references('id')->onDelete('cascade');
            $table->double('qty',20,2)->nullable();
            $table->date('date')->nullable();
            $table->boolean('hidden')->default(0);
            $table->longText('tek_marks')->nullable();
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
        Schema::dropIfExists('purchase_receiveds');
    }
}
