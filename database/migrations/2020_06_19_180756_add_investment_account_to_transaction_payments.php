<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInvestmentAccountToTransactionPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaction_payments', function (Blueprint $table) {
            $table->unsignedBigInteger('investment_account_id')->nullable()->after('account_id');
            $table->foreign('investment_account_id')->on('investment_accounts')->references('id')->onDelete('cascade');
            $table->string('payment_type')->default('account')->nullable()->after('investment_account_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaction_payments', function (Blueprint $table) {
            //
        });
    }
}
