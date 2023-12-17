<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaymentInformationToWorkOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('work_orders', function (Blueprint $table) {
            $table->double('total_item', 2)->nullable();
            $table->double('sub_total', 2)->nullable();
            $table->string('discount_type')->nullable();
            $table->double('discount_amount', 2)->nullable();
            $table->double('tax', 2)->nullable();
            $table->double('shiping_charge', 2)->nullable();
            $table->double('total_payable', 2)->nullable();
            $table->string('method')->nullable();
            $table->double('paid', 2)->nullable();
            $table->double('due', 2)->nullable();
            $table->string('check_no')->nullable();
            $table->longText('sell_note')->nullable();
            $table->longText('stuff_note')->nullable();
            $table->boolean('payment_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('work_orders', function (Blueprint $table) {
            //
        });
    }
}
