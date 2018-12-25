<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('contract_id');
            $table->string('payment_method_codename');
            $table->integer('method_request_id');
            $table->string('status');
            $table->string('payment_url');
            $table->float('total_ammount');
            $table->float('transaction_fee')->nullable();
            $table->float('net_ammount')->nullable();
            $table->string('currency_code');
            $table->datetime('date_paid')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_requests');
    }
}
