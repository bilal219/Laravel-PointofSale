<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_details', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->string('invoice_number');
            $table->integer('user_id');
            $table->integer('customer_id');
            $table->integer('product_id');
            $table->integer('qty');
            $table->integer('cost_price');
            $table->integer('retail_price');
            $table->string('status');
            $table->string('batch_no');
            $table->integer('total_costprice');
            $table->integer('total_fretailprice');
            $table->integer('fretail_price');
            $table->integer('discount');
            $table->integer('profit');
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
        Schema::dropIfExists('sale_details');
    }
}
