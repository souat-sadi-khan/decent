<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShortDescriptionToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('delivery_status')->nullable()->after('status');
            $table->longText('short_description')->nullable()->after('delivery_status');
            $table->longText('information')->nullable()->after('short_description');
            $table->longText('product_description')->nullable()->after('information');
            $table->longText('meta_description')->nullable()->after('product_description');
            $table->string('seo_title')->nullable()->after('meta_description');
            $table->string('title')->nullable()->after('seo_title');
            $table->string('keyword')->nullable()->after('title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['delivery_status', 'short_description', 'information', 'product_description', 'meta_description', 'seo_title', 'title', 'keyword']);
        });
    }
}
