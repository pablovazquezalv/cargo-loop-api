<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('companies')->insert([
            [
                'name' => 'Milwaukee',
                'address' => 'Address 1',
                'phone' => '1234567890',
                'email' => 'milwaukee@gmail.com',
                'website' => 'www.company1.com',
                'description' => 'Description for Company 1',
                'profile_picture' => 'profile1.jpg',
                'city' => 'City 1',
                'state' => 'State 1',
                'country' => 'Country 1',
                'postal_code' => '12345',
                'created_at' => now(),
                'updated_at' => now(),
            ],]);
        

    }
}
