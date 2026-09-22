<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'doucourepapesamba1@gmail.com',
            ],
            [
                'first_name' => 'DOUCOURE',
                'last_name' => 'Pape Samba',
                'phone' => '782921001',
                'password' => Hash::make('Doucoure@19772001'),
                'role' => 'admin',
                'status' => 'active',
            ]
        );
    }
}