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
            $table->integer('current_status_id');
            $table->integer('quotation_id');
            $table->integer('quotation_product_id');
            $table->integer('active_payment_req_id')->nullable();
            $table->string('beneficiary_1');
            $table->string('beneficiary_2')->nullable();
            $table->string('beneficiary_3')->nullable();
            $table->string('beneficiary_4')->nullable();
            $table->string('beneficiary_5')->nullable();
            $table->string('contact_phone');
            $table->string('contact_email');
            $table->string('emergency_contact_fullname');
            $table->string('emergency_contact_phone');
            $table->string('billing_fiscal_condition')->nullable();
            $table->string('billing_fullname')->nullable();
            $table->string('billing_tax_number')->nullable();
            $table->string('billing_address_street')->nullable();
            $table->string('billing_address_number')->nullable();
            $table->string('billing_address_appt')->nullable();
            $table->string('billing_address_city')->nullable();
            $table->string('billing_address_state')->nullable();
            $table->string('billing_address_zip')->nullable();
            $table->string('billing_address_country')->nullable();
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
