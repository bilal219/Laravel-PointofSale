<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_details', function (Blueprint $table) {
            $table->id();
            $table->string('Bus_Name');
            $table->string('Bus_Logo_Invoice');
            $table->string('Bus_Logo_Header');
            $table->string('Bus_Watermark_report');
            $table->string('Bus_Name_Ur');
            $table->string('Bus_Address');
            $table->string('Bus_Address_Ur');
            $table->string('Bus_Contact1');
            $table->string('Bus_Contact2');
            $table->string('Bus_Contact3');
            $table->string('Bus_email');
            $table->string('Bus_site');
            $table->string('Bus_Vat_Reg');
            $table->string('Bus_Language');
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
        Schema::dropIfExists('client_details');
    }
}
