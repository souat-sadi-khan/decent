<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOurWorkspacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('our_workspaces', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('image_one')->nullable();
            $table->string('image_one_alt')->nullable();
            $table->string('image_two')->nullable();
            $table->string('image_two_alt')->nullable();
            $table->string('image_three')->nullable();
            $table->string('image_three_alt')->nullable();
            $table->string('image_four')->nullable();
            $table->string('image_four_alt')->nullable();
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
        Schema::dropIfExists('our_workspaces');
    }
}
