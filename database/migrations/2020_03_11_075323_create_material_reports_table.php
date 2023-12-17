<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('store_request_id')->nullable();
            $table->foreign('store_request_id')->on('store_requests')
                ->references('id')->onDelete('cascade');
            $table->unsignedBigInteger('depertment_id')->nullable();
            $table->foreign('depertment_id')->on('depertments')
                ->references('id')->onDelete('cascade');
            $table->unsignedBigInteger('raw_material_id')->nullable();
            $table->foreign('raw_material_id')->on('raw_materials')
                ->references('id')->onDelete('cascade');
            $table->string('qty')->nullable();
            $table->string('waste')->nullable();
            $table->text('note')->nullable();
            $table->text('date')->nullable();
            $table->integer('done_material_report_id')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('material_reports');
    }
}
