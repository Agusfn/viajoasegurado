<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotations', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->dateTime('expiration_date');
            $table->string('customer_email');
            $table->integer('origin_country_code');
            $table->integer('destination_region_code');
            $table->integer('trip_type_code');
            $table->date('date_from');
            $table->date('date_to');
            $table->integer('passenger_ammount');
            $table->string('passenger_ages');
            $table->integer('gestation_weeks');
            $table->string('url_code');
            $table->string('lang');
            $table->string('customer_ip');
            $table->string('atv_token');
            $table->boolean('quoted');
            $table->integer('contract_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quotations');
    }
}
