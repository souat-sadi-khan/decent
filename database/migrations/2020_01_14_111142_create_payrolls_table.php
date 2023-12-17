<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid')->nullable();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->unsignedBigInteger('employee_salary_id')->nullable();
            $table->foreign('employee_salary_id')->references('id')->on('employee_salaries')->onDelete('cascade');
            $table->string('period')->nullable();
            $table->string('period_detail')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('per_day_calculation_basis')->nullable();
            $table->integer('user_defined_days')->nullable();
            $table->double('total',25,5)->nullable();
            $table->double('paid',25,5)->nullable();
            $table->string('payment_status')->nullable();
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('payrolls');
    }
}
