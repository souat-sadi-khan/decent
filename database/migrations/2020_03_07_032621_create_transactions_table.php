<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('client_id')->nullable();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->string('purchase_by')->nullable();
            $table->string('sale_type')->nullable();
            $table->string('reference_no')->nullable();
            $table->string('invoice_no')->nullable();
            $table->string('date')->nullable();
            $table->string('type')->nullable();
            $table->string('transaction_type')->nullable();
            $table->integer('work_order_id')->nullable();
            $table->string('status')->nullable();
            $table->double('sub_total',20,2)->nullable();
            $table->double('discount',20,2)->nullable();
            $table->string('discount_type')->nullable();
            $table->double('discount_amount',20,2)->nullable();
            $table->double('tax',20,2)->nullable();
            $table->double('shipping_charges',20,2)->nullable();
            $table->double('net_total',20,2)->nullable();
            $table->double('paid',20,2)->nullable();
            $table->double('due',20,2)->nullable();
            $table->string('payment_status')->nullable();
            $table->longText('stuff_note')->nullable();
            $table->longText('sell_note')->nullable();
            $table->longText('transaction_note')->nullable();
            $table->integer('return_parent_id')->nullable();
            $table->integer('return')->default(0);
            $table->enum('ecommerce_status', ['pending', 'confirm', 'progressing', 'shipment', 'success', 'cancel', 'on_hold', 'payment_done', 'return'])->nullable();	
            $table->boolean('hidden')->default(0);
            $table->longText('tek_marks')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
