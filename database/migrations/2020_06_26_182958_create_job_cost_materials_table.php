<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobCostMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_cost_materials', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('job_costing_id')->nullable();
            $table->foreign('job_costing_id')->on('job_costings')->references('id')->onDelete('cascade');
            $table->unsignedBigInteger('ingredients_category_id')->nullable();
            $table->foreign('ingredients_category_id')->on('ingredients_categories')->references('id')->onDelete('cascade');
            $table->unsignedBigInteger('raw_material_id')->nullable();
            $table->foreign('raw_material_id')->on('raw_materials')->references('id')->onDelete('cascade');
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->foreign('unit_id')->on('units')->references('id')->onDelete('cascade');
            $table->double('consumstion',20,2)->nullable();
            $table->double('unit_cost',20,2)->nullable();
            $table->double('cost_pr',20,2)->nullable();
            $table->integer('created_by')->nullable();
            $table->boolean('hidden')->default(0);
            $table->longText('tek_marks')->nullable();
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
        Schema::dropIfExists('job_cost_materials');
    }
}
