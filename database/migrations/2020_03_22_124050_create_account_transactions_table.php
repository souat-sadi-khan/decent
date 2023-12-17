<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('account_id')->nullable();
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->integer('investment_account_id')->nullable();
            $table->integer('expense_id')->nullable();
            $table->string('acc_type')->nullable();
            $table->enum('type', ['Debit', 'Credit']);
            $table->enum('sub_type', ['opening_balance', 'fund_transfer', 'deposit','withdraw','expense'])->nullable();
            $table->double('amount', 10, 2);
            $table->string('reff_no')->nullable();
            $table->dateTime('operation_date');
            $table->integer('transaction_id')->nullable();
            $table->integer('transaction_payment_id')->nullable();
            $table->integer('transfer_transaction_id')->nullable();
            $table->text('note')->nullable();
            $table->integer('created_by')->nullable();
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
        Schema::dropIfExists('account_transactions');
    }
}
