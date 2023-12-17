<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPairCostingToProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
          $table->float('default_purchase_price', 20, 2)->default(0)->after('hot_sale_price');
          $table->float('profit_percent', 20, 2)->default(0)->after('default_purchase_price');;
          $table->float('default_sell_price', 20, 2)->default(0)->after('profit_percent');; 
          $table->float('rejection', 20, 2)->default(0)->after('default_sell_price');
          $table->float('rejection_amt', 20, 2)->default(0)->after('rejection');
          $table->float('overhead', 20, 2)->default(0)->after('rejection_amt');
          $table->float('profit_amt', 20, 2)->default(0)->after('overhead');
          $table->float('commercial', 20, 2)->default(0)->after('profit_amt');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
}
