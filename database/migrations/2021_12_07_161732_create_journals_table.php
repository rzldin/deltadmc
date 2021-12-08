<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJournalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_journals', function (Blueprint $table) {
            $table->id();
            $table->date('journal_date');
            $table->integer('account_id')->unsigned()->default(0);
            $table->integer('currency_id')->unsigned()->default(0);
            $table->string('transaction_type', 1);
            $table->decimal('amount', 25, 4);
            $table->text('memo');
            $table->integer('transaction_group_id')->unsigned()->default(0);
            $table->integer('attr1')->nullable()->unsigned()->default(0);
            $table->integer('attr2')->nullable()->unsigned()->default(0);
            $table->string('attr3', 100)->nullable();
            $table->string('attr4', 100)->nullable();
            $table->string('attr5', 100)->nullable();
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
        Schema::dropIfExists('t_journals');
    }
}
