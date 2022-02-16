<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExternalInvoiceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_external_invoice_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('external_invoice_id');
            $table->integer('position_no');
            $table->integer('t_mcharge_code_id')->nullable();
            $table->text('desc')->nullable();
            $table->integer('reimburse_flag')->nullable();
            $table->integer('currency')->nullable();
            $table->decimal('rate', 14, 2);
            $table->decimal('cost', 14, 2);
            $table->decimal('sell', 14, 2);
            $table->integer('qty')->nullable();
            $table->decimal('cost_val', 14, 2);
            $table->decimal('sell_val', 14, 2);
            $table->decimal('vat', 14, 2)->nullable();
            $table->decimal('pph23', 14, 2)->nullable()->default(0);
            $table->decimal('subtotal', 14, 2);
            $table->string('routing', 100)->nullable();
            $table->string('transit_time', 50)->nullable();
            $table->string('created_by', 100)->nullable();
            $table->dateTime('created_on')->nullable();
            $table->index('external_invoice_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_external_invoice_detail');
    }
}
