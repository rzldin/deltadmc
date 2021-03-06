<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKasMasukDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_kas_masuk_details', function (Blueprint $table) {
            $table->id();
            $table->integer('kas_masuk_id')->index();
            $table->integer('account_id')->index();
            $table->decimal('amount', 14, 2);
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
        Schema::dropIfExists('t_kas_masuk_details');
    }
}
