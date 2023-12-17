<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDesignationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('designations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_category_id')->nullable(); 
            $table->foreign('employee_category_id')->references('id')->on('employee_categories')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->unsignedBigInteger('top_designation_id')->nullable();
            $table->foreign('top_designation_id')->references('id')->on('designations')->onDelete('set null');
            $table->text('description')->nullable();
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
        Schema::dropIfExists('employee_designations');
    }
}
