<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('contract_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name_english");
            $table->string("color");
        });

        // Estados de pedidos
        DB::table('contract_statuses')->insert([
            array('id' => 1, 'name_english' => 'Payment pending', 'color' => '#4169E1'), // azul oscuro
            array('id' => 2, 'name_english' => 'Processing', 'color' => '#FF8C00'),  // naranja 
            array('id' => 3, 'name_english' => 'Completed', 'color' => '#108510'), // verde oscuro
            array('id' => 4, 'name_english' => 'Expired', 'color' => '#ec2e15'), // rojo
            array('id' => 5, 'name_english' => 'Canceled', 'color' => '#8f0621'), // rojo oscuro
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contract_statuses');
    }
}
