<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_invoice_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('invoice_id');
            $table->integer('position_no');
            $table->integer('t_mcharge_code_id')->nullable();
            $table->text('desc')->nullable();
            $table->integer('reimburse_flag')->nullable();
            $table->integer('currency')->nullable();
            $table->decimal('rate', 25, 4);
            $table->decimal('cost', 25, 4);
            $table->decimal('sell', 25, 4);
            $table->integer('qty')->nullable();
            $table->decimal('cost_val', 25, 4);
            $table->decimal('sell_val', 25, 4);
            $table->decimal('vat', 25, 4)->nullable();
            $table->decimal('subtotal', 25, 4);
            $table->string('routing', 100)->nullable();
            $table->string('transit_time', 50)->nullable();
            $table->string('created_by', 100)->nullable();
            $table->dateTime('created_on')->nullable();
            $table->index('invoice_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_invoice_detail');
    }
}
