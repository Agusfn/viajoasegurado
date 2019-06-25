<?php

use Illuminate\Database\Seeder;

class PaymentMethodsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
}
