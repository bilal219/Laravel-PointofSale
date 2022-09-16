<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->string('generic_name');
            $table->string('UPC_EAN');
            $table->string('inventory');
            $table->string('product_status');
            $table->string('product_type');
            $table->string('manage_stock');
            $table->string('product_image');
            $table->bigInteger('cat_id');
            $table->bigInteger('uom_id');
            $table->float('costprice',10,2);
            $table->float('retailprice',10,2);
            $table->float('discount',10,2);
            $table->float('fretailprice',10,2);
            $table->float('qty');
            $table->float('reorder_qty');
            $table->date('expirydate');
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
        Schema::dropIfExists('products');
    }
}
