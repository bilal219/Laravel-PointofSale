<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('cust_name');
            $table->string('address');
            $table->string('contact');
            $table->string('cnic');
            $table->string('email');
            $table->string('cust_image');
            $table->string('fathername');
            $table->bigInteger('area_id');
            $table->string('cust_type');
            $table->string('status');
            $table->bigInteger('supp_id');
            $table->Integer('witness1');
            $table->Integer('witness2');
            $table->Integer('witness3');
            $table->Integer('type_id');
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
        Schema::dropIfExists('customers');
    }
}
