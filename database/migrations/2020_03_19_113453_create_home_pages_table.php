<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHomePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('home_pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id')->on('products')->references('id')->onDelete('cascade');
            $table->string('banner_image_one_check')->nullable();
            $table->string('banner_image_one')->nullable();
            $table->string('banner_image_one_alt')->nullable();
            $table->string('banner_image_two_check')->nullable();
            $table->string('banner_image_two')->nullable();
            $table->string('banner_image_two_alt')->nullable();
            $table->string('banner_frame_one')->nullable();
            $table->string('banner_frame_one_alt')->nullable();
            $table->string('banner_frame_two')->nullable();
            $table->string('banner_frame_two_alt')->nullable();
            $table->string('tab_slider_image')->nullable();
            $table->string('tab_slider_image_alt')->nullable();
            $table->string('sale_category_image')->nullable();
            $table->string('sale_category_image_alt')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('update_by')->nullable();
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
        Schema::dropIfExists('home_pages');
    }
}
