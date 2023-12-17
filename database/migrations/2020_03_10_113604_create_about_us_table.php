<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAboutUsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('about_us', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable;
            $table->string('header_image')->nullable;
            $table->string('header_image_alt')->nullable;
            $table->string('seo_title')->nullable;
            $table->string('meta_keyword')->nullable;
            $table->text('meta_description')->nullable;
            $table->text('description')->nullable;
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
        Schema::dropIfExists('about_us');
    }
}
