<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMercadoPagoRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mercado_pago_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->integer('payment_request_id')->nullable();
            $table->integer('item_id');
            $table->string('item_title');
            $table->integer('item_quantity');
            $table->string('item_currency_code');
            $table->float('item_unit_price', 8, 2);
            $table->string('payer_email');
            $table->string('payer_name');
            $table->string('payer_surname');
            $table->string('failure_url_token');
            $table->string('expiration_date');
            $table->string('preference_id')->nullable();
            $table->string('preference_url')->nullable();
            $table->string('preference_sandbox_url')->nullable();
            $table->bigInteger('merchant_order_id')->nullable();
            $table->bigInteger('collection_id')->nullable();
            $table->string('collection_method')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mercado_pago_requests');
    }
}
