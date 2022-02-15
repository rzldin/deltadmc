<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExternalInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_external_invoice', function (Blueprint $table) {
            $table->id();
            $table->integer('t_proforma_invoice_id');
            $table->integer('t_booking_id');
            $table->integer('client_id')->nullable();
            $table->integer('client_addr_id')->nullable();
            $table->integer('client_pic_id')->nullable();
            $table->string('activity', 50)->nullable();
            $table->string('external_invoice_no');
            $table->string('truck_no', 20)->nullable();
            $table->integer('currency');
            $table->decimal('rate', 25, 4)->default(0);
            $table->decimal('total_before_vat', 14, 2)->default(0);
            $table->decimal('total_vat', 14, 2)->default(0);
            $table->decimal('pph23', 14, 2)->default(0);
            $table->decimal('total_invoice', 25, 4)->default(0);
            $table->decimal('invoice_bayar', 25, 4)->default(0);
            $table->tinyInteger('flag_bayar')->default(0);
            $table->integer('reimburse_flag')->nullable();
            $table->integer('debit_note_flag')->nullable();
            $table->integer('credit_note_flag')->nullable();
            $table->date('external_invoice_date');
            $table->integer('top')->unsigned()->default(0);
            $table->text('mbl_shipper')->nullable();
            $table->text('mbl_consignee')->nullable();
            $table->text('mbl_not_party')->nullable();
            $table->string('mbl_no', 100)->nullable();
            $table->date('mbl_date')->nullable();
            $table->integer('valuta_mbl')->nullable();
            $table->text('hbl_shipper')->nullable();
            $table->text('hbl_consignee')->nullable();
            $table->text('hbl_not_party')->nullable();
            $table->string('hbl_no', 100)->nullable();
            $table->date('hbl_date')->nullable();
            $table->integer('valuta_hbl')->nullable();
            $table->string('vessel')->nullable();
            $table->string('m_vessel')->nullable();
            $table->integer('pol_id')->nullable();
            $table->integer('pod_id')->nullable();
            $table->date('onboard_date')->nullable();
            $table->string('created_by', 100)->nullable();
            $table->dateTime('created_on')->nullable();
            $table->index('t_invoice_id');
            $table->index('t_booking_id');
            $table->index('client_id');
            $table->index('client_addr_id');
            $table->index('client_pic_id');
            $table->index('external_invoice_no');
            $table->index('pol_id');
            $table->index('pod_id');
            $table->index('created_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_external_invoice');
    }
}
