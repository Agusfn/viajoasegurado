<?php

use Illuminate\Database\Seeder;

class CurrenciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Monedas iniciales
        DB::table('currencies')
            ->insert(
                array(
                    array(
                        'code' => 'USD',
                        'name_english' => 'United States Dollar', 
                        'symbol' => '$'
                    ),
                    array(
                        'code' => 'ARS',
                        'name_english' => 'Argentine Peso', 
                        'symbol' => '$'
                    ),
                    array(
                        'code' => 'EUR',
                        'name_english' => 'Euros',
                        'symbol' => '€'
                    )
                )
            );
    }
}
