<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWholeSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('whole_sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('header')->nullable;
            $table->string('catelog')->nullable();
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
        Schema::dropIfExists('whole_sales');
    }
}
