<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayrollTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->string('payroll_id')->nullable();
            $table->string('head')->nullable();
            $table->double('amount', 2)->nullable();
            $table->timestamp('date_of_transaction')->nullable();
            $table->unsignedBigInteger('created_id')->nullable();
            $table->foreign('created_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('payment_method')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('account_holder')->nullable();
            $table->string('account_no')->nullable();
            $table->string('check_no')->nullable();
            $table->string('check_active_date')->nullable();
            $table->string('mob_banking_name')->nullable();
            $table->string('mob_account_holder')->nullable();
            $table->string('sending_mob_no')->nullable();
            $table->string('receiving_mob_no')->nullable();
            $table->string('mob_tx_id')->nullable();
            $table->string('document')->nullable();
            $table->string('tx_type')->nullable();
            $table->longtext('additional_note')->nullable();
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
        Schema::dropIfExists('payroll_transactions');
    }
}
