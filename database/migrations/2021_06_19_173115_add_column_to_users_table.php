<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username', 20)->after('name');
            $table->string('address', 150)->after('username');
            $table->string('city', 50)->after('address');
            $table->string('postal_code', 50)->after('city');
            $table->string('state_code', 50)->after('postal_code');
            $table->string('province', 100)->after('state_code');
            $table->string('country_code', 50)->after('province');
            $table->string('country_name', 100)->after('country_code');
            $table->string('phone1', 50)->after('country_name');
            $table->string('phone2', 50)->after('phone1');
            $table->string('fax', 50)->after('phone2');
            $table->integer('active_flag')->length(1)->after('fax');
            $table->string('created_by', 100)->after('remember_token');  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['username', 'address', 'city', 'postal_code', 'state_code', 'province', 'country_code', 'country_name', 'phone1', 'phone2', 'fax', 'active_flag', 'created_by']);
        });
    }
}
