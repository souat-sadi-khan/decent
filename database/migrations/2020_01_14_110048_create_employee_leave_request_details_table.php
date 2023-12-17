<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeLeaveRequestDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_leave_request_details', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('employee_leave_request_id')->nullble();
            $table->foreign('employee_leave_request_id', 'elrd_employee_leave_request_id')->references('id')->on('employee_leave_requests')->onDelete('cascade');
			$table->unsignedBigInteger('designation_id')->nullable();
			$table->foreign('designation_id', 'elrd_designation_id_foreign')->references('id')->on('designations')->onDelete('cascade');
			$table->date('date_of_action')->nullable();
			$table->string('status', 20)->nullable();
			$table->text('comment')->nullable();
			$table->unsignedBigInteger('approver_user_id')->nullable();
			$table->foreign('approver_user_id', 'elrd_approver_user_id_foreign')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('employee_leave_request_details');
    }
}
