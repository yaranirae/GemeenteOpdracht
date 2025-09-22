<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Gemeente Admin',
            'email' => 'admin@admin.nl',
            'password' => Hash::make('admin123'),
            //'is_admin' => true
        ]);
    }
}