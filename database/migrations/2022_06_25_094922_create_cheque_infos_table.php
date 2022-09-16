<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChequeInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cheque_infos', function (Blueprint $table) {
            $table->id();
            $table->integer('cust_id');
            $table->integer('chq_number');
            $table->float('chq_amount');
            $table->string('status');
            $table->string('note');
            $table->integer('supp_id');
            $table->integer('user_id');
            $table->string('clear_note');
            $table->string('payment_method');
            $table->date('clear_date');
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
        Schema::dropIfExists('cheque_infos');
    }
}
