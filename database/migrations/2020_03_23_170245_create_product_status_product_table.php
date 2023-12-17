<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductStatusProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('hot_sale_status')->nullable()->after('tek_marks');
            $table->string('hot_sale_price')->nullable()->after('hot_sale_status');
            $table->string('feature_product_status')->nullable()->after('hot_sale_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        $table->dropForeign(['hot_sale_status', 'feature_product_status']);
    }
}
