<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeLeaveAllocationDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_leave_allocation_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_leave_allocation_id')->nullable();
            $table->foreign('employee_leave_allocation_id', 'elad_employee_leave_allocation_id')->references('id')->on('employee_leave_allocations')->onDelete('cascade');
            $table->unsignedBigInteger('employee_leave_type_id')->nullable();
            $table->foreign('employee_leave_type_id', 'elad_employee_leave_type_id')->references('id')->on('employee_leave_types')->onDelete('cascade');
            $table->Integer('allotted')->nullable();
            $table->Integer('used')->nullable();
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
        Schema::dropIfExists('employee_leave_allocation_details');
    }
}
