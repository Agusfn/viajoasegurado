<?php

use Illuminate\Database\Seeder;

class ContractStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Estados de pedidos
        DB::table('contract_statuses')->insert([
            array('id' => 1, 'name_english' => 'Payment pending', 'color' => '#4169E1'), // azul oscuro
            array('id' => 2, 'name_english' => 'Processing', 'color' => '#FF8C00'),  // naranja 
            array('id' => 3, 'name_english' => 'Completed', 'color' => '#108510'), // verde oscuro
            array('id' => 4, 'name_english' => 'Expired', 'color' => '#ec2e15'), // rojo
            array('id' => 5, 'name_english' => 'Canceled', 'color' => '#8f0621'), // rojo oscuro
        ]);
    }
}
