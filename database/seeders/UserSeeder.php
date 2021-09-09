<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create([
            'name' => 'Laisha Olivarria',
            'phone' => '3112026398',
            'email' => 'laisha@hotmail.com',
            'profile' => 'ADMINISTRADOR',
            'status' => 'ACTIVO',
            'password' => bcrypt('123')
        ]);
        User::create([
            'name' => 'Daniel Contreras Perez',
            'phone' => '3112026378',
            'email' => 'daniel@gmail.com',
            'profile' => 'EMPLEADO',
            'status' => 'ACTIVO',
            'password' => bcrypt('123')
        ]);
    }
}
