<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionSellLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_sell_lines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('transaction_id')->nullable();
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
            $table->unsignedBigInteger('client_id')->nullable();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->unsignedBigInteger('variation_id')->nullable();
            $table->foreign('variation_id')->references('id')->on('variations')->onDelete('cascade');
            $table->unsignedBigInteger('variation_brand_detail_id')->nullable();
            $table->foreign('variation_brand_detail_id')->references('id')->on('variation_brand_details')->onDelete('cascade');
            $table->integer('brand_id')->nullable();
            $table->decimal('quantity',20,2);
            $table->decimal('quantity_returned',20,2);
            $table->decimal('unit_price', 20, 2)->comment("Sell price excluding tax")->nullable();
            $table->decimal('total',20,2)->nullable();
            $table->integer('parent_sell_line_id')->nullable();
            $table->string('sale_type')->default('ecommerce')->nullable();
            $table->boolean('hidden')->default(0);
            $table->longText('tek_marks')->nullable();
            $table->integer('created_by')->nullable();
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
        Schema::dropIfExists('transaction_sell_lines');
    }
}
