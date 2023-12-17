<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobCostingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_costings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id')->on('products')->references('id')->onDelete('cascade');
            $table->string('cost_id')->nullable();
            $table->double('total_material_cost',20,2)->nullable();
            $table->double('rejection',20,2)->nullable();
            $table->double('rejection_amt',20,2)->nullable();
            $table->double('overhead',20,2)->nullable();
            $table->double('profit_percent',20,2)->nullable();
            $table->double('profit_amt',20,2)->nullable();
            $table->double('commercial',20,2)->nullable();
            $table->double('grand_total',20,2)->nullable();
            $table->date('date')->nullable();
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
        Schema::dropIfExists('job_costings');
    }
}
