<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWopMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wop_materials', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('wo_id')->nullable();
            $table->string('wop_id')->nullable();
            $table->string('raw_material_id')->nullable();
            $table->string('qty')->nullable();
            $table->string('unit_price')->nullable();
            $table->string('price')->nullable();
            $table->string('waste')->nullable();
            $table->string('uses')->nullable();
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
        Schema::dropIfExists('wop_materials');
    }
}
