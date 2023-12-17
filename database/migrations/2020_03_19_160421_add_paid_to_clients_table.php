<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaidToClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('last_name')->nullable()->after('name');
            $table->string('user_name')->nullable()->after('last_name');
            $table->string('company_name')->nullable()->after('user_name');
            $table->string('address')->nullable()->after('company_name');
            $table->string('password')->nullable()->after('address');
            $table->string('post_code')->nullable()->after('password');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropForeign(['last_name', 'user_name', 'company_name', 'address', 'password', 'post_code']);
        });
    }
}
