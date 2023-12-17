<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeramsConditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('terams_conditions', function (Blueprint $table) {
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
        Schema::dropIfExists('terams_conditions');
    }
}
