<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPairCostingToVariations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('variations', function (Blueprint $table) {
            
          $table->float('rejection', 20, 2)->default(0)->after('default_purchase_price');
          $table->float('rejection_amt', 20, 2)->default(0)->after('rejection');
          $table->float('overhead', 20, 2)->default(0)->after('rejection_amt');
          $table->float('profit_amt', 20, 2)->default(0)->after('profit_percent');
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
        Schema::table('variations', function (Blueprint $table) {
            //
        });
    }
}
