<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayrollTemplateDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_template_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('payroll_template_id')->nullable();
            $table->foreign('payroll_template_id')->references('id')->on('payroll_templates')->onDelete('cascade');
            $table->unsignedBigInteger('pay_head_id')->nullable();
            $table->foreign('pay_head_id')->references('id')->on('pay_heads')->onDelete('cascade');
            $table->unsignedBigInteger('employee_attendance_type_id')->nullable();
            $table->foreign('employee_attendance_type_id')->references('id')->on('employee_attendance_types')->onDelete('cascade');
            $table->integer('position')->nullable();
            $table->string('category')->nullable();
            $table->string('computation')->nullable();
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
        Schema::dropIfExists('payroll_template_details');
    }
}
