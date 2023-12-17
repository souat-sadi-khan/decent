<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayrollDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('payroll_id')->nullable();
            $table->foreign('payroll_id')->references('id')->on('payrolls')->onDelete('cascade');
            $table->unsignedBigInteger('pay_head_id')->nullable();
            $table->foreign('pay_head_id')->references('id')->on('pay_heads')->onDelete('cascade');
            $table->decimal('amount',25,5)->default(0);
            $table->text('options')->nullable();
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
        Schema::dropIfExists('payroll_details');
    }
}
