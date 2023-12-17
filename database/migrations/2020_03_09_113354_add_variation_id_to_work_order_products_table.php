<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVariationIdToWorkOrderProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('work_order_products', function (Blueprint $table) {
            $table->unsignedBigInteger('variation_id')->nullable()->after('product_id');
            $table->foreign('variation_id')->on('variations')
                ->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('work_order_products', function (Blueprint $table) {
            $table->dropForeign(['variation_id']);
        });
    }
}
