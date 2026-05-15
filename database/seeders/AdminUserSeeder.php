<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create([
            'name' => 'Admin PLANOVA',
            'email' => 'admin@planova.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
    }
}
