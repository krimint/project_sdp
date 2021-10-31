<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailTrxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_trxes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trx_id')->constrained('trxes')->onDelete('cascade');
            $table->string('jenis');
            $table->integer('qty');
            $table->boolean('status_payment');
            $table->string('jenis_payment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_trxes');
    }
}
