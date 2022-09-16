<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceNosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_nos', function (Blueprint $table) {
            $table->id();
            $table->integer('invoice_no');
            $table->integer('purchase_invoice_no');
            $table->integer('cust_acc_invoive_no');
            $table->integer('supp_acc_invoice_no');
            $table->integer('emp_acc_invoice_no');
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
        Schema::dropIfExists('invoice_nos');
    }
}
