<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVariationTemplateDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variation_template_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('variation_template_id')->nullable();
            $table->foreign('variation_template_id')->references('id')->on('variation_templates')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->boolean('hidden')->nullable();
            $table->longText('tek_marks')->nullable();
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
        Schema::dropIfExists('variation_template_details');
    }
}
