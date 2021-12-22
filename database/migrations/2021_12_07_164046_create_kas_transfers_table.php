<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKasTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_kas_transfers', function (Blueprint $table) {
            $table->id();
            $table->integer('from_account_id')->unsigned()->default(0);
            $table->integer('to_account_id')->unsigned()->default(0);
            $table->date('transfer_date');
            $table->string('reference')->nullable();
            $table->decimal('amount', 14, 2);
            $table->string('memo')->nullable();
            $table->string('created_by', 100)->nullable();
            $table->dateTime('created_on')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_kas_transfers');
    }
}
