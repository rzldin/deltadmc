<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_general_ledgers', function (Blueprint $table) {
            $table->id();
            $table->integer('journal_id')->unsigned()->default(0);
            $table->integer('account_id')->unsigned()->default(0);
            $table->string('transaction_type', 1);
            $table->decimal('debit', 25, 4)->default(0);
            $table->decimal('credit', 25, 4)->default(0);
            $table->decimal('balance', 25, 4)->default(0);
            $table->text('memo')->nullable();
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
        Schema::dropIfExists('t_general_ledgers');
    }
}
