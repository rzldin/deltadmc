<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKasMasuksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_kas_masuk', function (Blueprint $table) {
            $table->id();
            $table->date('kas_masuk_date');
            $table->integer('account_id')->index();
            $table->text('memo');
            $table->integer('client_id')->default(0)->unsigned();
            $table->integer('currency_id')->default(0)->unsigned();
            $table->string('transaction_no')->nullable();
            $table->string('transaction_date')->nullable();
            $table->decimal('total', 14, 2);
            $table->string('no_giro')->nullable();
            $table->date('due_date')->nullable();
            $table->string('bank')->nullable();
            $table->string('bank_account')->nullable();
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
        Schema::dropIfExists('t_kas_masuk');
    }
}
