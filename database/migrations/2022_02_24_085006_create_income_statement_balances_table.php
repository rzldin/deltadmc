<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomeStatementBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_income_statement_balances', function (Blueprint $table) {
            $table->id();
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedInteger('currency_id');
            $table->decimal('net_profit', 14, 2)->default(0);
            $table->decimal('other_income', 14, 2)->default(0);
            $table->decimal('operating_income', 14, 2)->default(0);
            $table->decimal('operating_expenses', 14, 2)->default(0);
            $table->decimal('gross_profit', 14, 2)->default(0);
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
        Schema::dropIfExists('t_income_statement_balances');
    }
}
