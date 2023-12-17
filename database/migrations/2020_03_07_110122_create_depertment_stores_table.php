<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepertmentStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('depertment_stores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('dstore_id')->nullable();
            $table->unsignedBigInteger('depertment_id')->nullable();
            $table->foreign('depertment_id')->references('id')->on('depertments')->onDelete('cascade');
            $table->string('status')->nullable();
            $table->string('request_date')->nullable();
            $table->string('approve_date')->nullable();
            $table->boolean('hidden')->default(0);
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
        Schema::dropIfExists('depertment_stores');
    }
}
