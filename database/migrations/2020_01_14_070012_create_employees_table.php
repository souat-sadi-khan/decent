<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
             $table->bigIncrements('id');
            $table->string('uuid')->nullable();
            $table->string('prefix')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('shift_id')->nullable();
            $table->foreign('shift_id')->references('id')->on('employee_shifts')->onDelete('cascade');
			$table->date('date_of_action')->nullable();
            $table->integer('code')->nullable();
            $table->string('name')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('date_of_anniversary')->nullable();
            $table->string('gender')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('alternate_contact_number')->nullable();
            $table->string('email')->nullable();
            $table->string('alternate_email')->nullable();
            $table->string('nationality')->nullable();
            $table->string('photo')->nullable();
            $table->string('mother_tongue')->nullable();
            $table->string('unique_identification_number')->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('present_address_line_1')->nullable();
            $table->string('present_address_line_2')->nullable();
            $table->string('present_city')->nullable();
            $table->string('present_state')->nullable();
            $table->string('present_zipcode')->nullable();
            $table->string('present_country')->nullable();
            $table->string('same_as_present_address')->nullable();
            $table->string('permanent_address_line_1')->nullable();
            $table->string('permanent_address_line_2')->nullable();
            $table->string('permanent_city')->nullable();
            $table->string('permanent_state')->nullable();
            $table->string('permanent_zipcode')->nullable();
            $table->string('permanent_country')->nullable();
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
        Schema::dropIfExists('employees');
    }
}
