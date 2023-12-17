<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeSalaryDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_salary_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_salary_id')->nullable();
            $table->foreign('employee_salary_id')->references('id')->on('employee_salaries')->onDelete('cascade');
            $table->unsignedBigInteger('payroll_template_detail_id')->nullable();
            $table->foreign('payroll_template_detail_id')->references('id')->on('payroll_template_details')->onDelete('cascade');
            $table->double('amount',25,5)->nullable();
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
        Schema::dropIfExists('employee_salary_details');
    }
}
