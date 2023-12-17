<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDepertmentStoreIdToMaterialReports extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('material_reports', function (Blueprint $table) {
            $table->unsignedBigInteger('depertment_store_id')->nullable()->after('id');
            $table->foreign('depertment_store_id')->references('id')->on('depertment_stores')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('material_reports', function (Blueprint $table) {
            //
        });
    }
}
