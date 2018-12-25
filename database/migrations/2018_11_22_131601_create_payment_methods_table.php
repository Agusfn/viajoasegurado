<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->string('code_name');
            $table->string('name');
            $table->string('currency_code', 5);

            $table->primary('code_name');
        });


        // Agregamos medios de pago iniciales
        DB::table('payment_methods')->insert([
            'code_name' => 'paypal',
            'name' => 'PayPal',
            'currency_code' => 'USD'
        ]);

        DB::table('payment_methods')->insert([
            'code_name' => 'mercadopago-ar',
            'name' => 'MercadoPago',
            'currency_code' => 'ARS'
        ]);



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_methods');
    }
}
