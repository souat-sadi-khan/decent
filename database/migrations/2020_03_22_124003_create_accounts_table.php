<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('account_number');
            // $table->enum('account_type', ['saving_current', 'capital','deposite','withdraw'])->nullable();
            $table->string('account_type')->nullable();
            $table->text('note')->nullable();
            $table->integer('created_by')->nullable();
            $table->boolean('hidden')->default(0);
            $table->longText('tek_marks')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->boolean('is_closed')->default(0);
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
        Schema::dropIfExists('accounts');
    }
}
