<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
             'name' => 'Administrador',
             'email' => 'admin@tj.org',
             'admin' => true,
             'password' => 'admin@2023',
         ]);
    }
}
