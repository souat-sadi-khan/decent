<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid')->nullable();
            $table->string('prefix')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('code')->nullable();
            $table->string('name_in_bangla')->nullable();
            $table->string('name_in_english')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('date_of_anniversary')->nullable();
            $table->string('gender')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('alternate_contact_number')->nullable();
            $table->string('email')->nullable();
            $table->string('alternate_email')->nullable();
            $table->Integer('nationality_id')->nullable();
            $table->Integer('religious_id')->nullable();
            $table->Integer('occupation_id')->nullable();
            $table->string('photo')->nullable();
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
            $table->unsignedBigInteger('referrer_id')->nullable();
            $table->foreign('referrer_id')->references('id')->on('members')->onDelete('set null');
            $table->Integer('created_by')->nullable();
            $table->Integer('verified_by')->nullable();
            $table->Integer('submitted_by')->nullable();
            $table->string('nid')->nullable();
            $table->string('birth_certificate_number')->nullable();
            $table->timestamp('approved_date')->nullable();
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
        Schema::dropIfExists('members');
    }
}
