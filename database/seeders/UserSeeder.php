<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'User Merchant',
            'email' => 'merchant@example.com',
            'password' => Hash::make('password'),
            'merchant_id' => 1,
        ]);
        DB::table('users')->insert([
            'name' => 'User Customer',
            'email' => 'customer@example.com',
            'password' => Hash::make('password'),
            'customer_id' => 1,
        ]);
    }
}
