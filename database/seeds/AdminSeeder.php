<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Agregamos admin user
        DB::table('users')->insert([
            'role' => 'superadmin',
            'name' => 'Daniela',
            'email' => 'info@studytripnz.com',
            'password' => bcrypt('viajo123asegurado'),
        ]);
    }
}
