<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepositDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_deposit_details', function (Blueprint $table) {
            $table->id();
            $table->integer('deposit_id');
            $table->date('deposit_date');
            $table->decimal('amount', 25, 4)->default(0);
            $table->integer('invoice_id')->nullable()->default(0);
            $table->text('remark')->nullable();
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
        Schema::dropIfExists('t_deposit_details');
    }
}
