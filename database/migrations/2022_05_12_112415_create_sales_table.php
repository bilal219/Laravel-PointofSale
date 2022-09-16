<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->Integer('cust_id');
            $table->Integer('user_id');
            $table->date('sale_date');
            $table->Integer('order_total');
            $table->string('invoice_number');
            $table->Integer('discount');
            $table->Integer('total_amount');
            $table->Integer('payment_amount');
            $table->Integer('change_amount');
            $table->string('payment_method');
            $table->string('status');
            $table->Integer('profit');
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
        Schema::dropIfExists('sales');
    }
}
