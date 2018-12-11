<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('currencies', function (Blueprint $table) {

            $table->string('code', 5); // PK
            $table->string('name_english');
            $table->string('symbol', 5);

            $table->primary('code');
        });

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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currencies');
    }
}
