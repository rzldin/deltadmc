<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigReportBalanceSheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_config_report_balance_sheets', function (Blueprint $table) {
            $table->id();
            $table->integer('account_id')->unsigned();
            $table->boolean('flag_pemasukan')->default(0);
            $table->boolean('flag_pengeluaran')->default(0);
            $table->string('created_by', 100)->nullable();
            $table->dateTime('created_on')->nullable();
            $table->string('updated_by', 100)->nullable();
            $table->dateTime('updated_on')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('config_report_balance_sheets');
    }
}
