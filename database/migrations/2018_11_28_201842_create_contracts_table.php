<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->bigInteger('number');
            $table->string('status_code');
            $table->integer('active_payment_req_id')->nullable();
            $table->integer('quotation_id');
            $table->integer('quotation_product_id');
            $table->string('subscriber_name');
            $table->string('subscriber_surname');
            $table->string('subscriber_email');
            $table->string('subscriber_address');
            $table->string('subscriber_city');
            $table->string('subscriber_state');
            $table->string('subscriber_zip');
            $table->string('subscriber_country');
            $table->string('subscriber_phone');
            $table->string('emergency_contact_fullname');
            $table->string('emergency_contact_phone');
            $table->string('billing_fullname');
            $table->string('billing_address');
            $table->string('billing_id_number');
            $table->string('beneficiary_1');
            $table->string('beneficiary_2');
            $table->string('beneficiary_3');
            $table->string('beneficiary_4');
            $table->string('beneficiary_5');
            $table->float('final_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contracts');
    }
}
