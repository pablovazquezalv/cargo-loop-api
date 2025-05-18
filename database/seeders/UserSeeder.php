<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        //ADMIN ENCARGADO DE APROBAR EMPRESAR, REPARTIDORES ETC
        DB::table('users')->insert([
            'name' => 'admin',
            'rol_id' => 1,
            'email' => 'admin@gmail.com',
            'phone' => '8718458147',
            'password' => bcrypt('admin123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        //MANAGER ENCARGADO DE APROBAR REPARTIDORES
        DB::table('users')->insert([
            'name' => 'manager',
            'rol_id' => 2,
            'email' => 'manager@gmail.com',
            'phone' => '8718458146',
            'password' => bcrypt('manager123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        //REPARTIDOR PARA TRABAJAR EN UNA EMPRESA O NO
        DB::table('users')->insert([
            'name' => 'dealer',
            'rol_id' => 3,
            'email' => 'dealer@gmail.com',
            'phone' => '8718458145',
            'password' => bcrypt('m123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'dealer',
            'rol_id' => 3,
            'email' => 'dealerwithnocompany@gmail.com',
            'phone' => '8718458145',
            'password' => bcrypt('m123'),
            'created_at' => now(),
            'updated_at' => now(),
            'company_id' => 1,
        ]);

        




        //No tiene empresa
        DB::table('users')->insert([
            'name' => 'client',
            'rol_id' => 4,
            'email' => 'client@gmail.com',
            'phone' => '8718458144',
            'password' => bcrypt('client123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}
