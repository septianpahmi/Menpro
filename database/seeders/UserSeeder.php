<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'surveyor',
            'email' => 'surveyor@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'surveyor',
        ]);
        User::create([
            'name' => 'desainer',
            'email' => 'desainer@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'desainer',
        ]);
        User::create([
            'name' => 'drafter',
            'email' => 'drafter@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'drafter',
        ]);
        User::create([
            'name' => 'estimator',
            'email' => 'estimator@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'estimator',
        ]);
        User::create([
            'name' => 'supervisor',
            'email' => 'supervisor@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'supervisor',
        ]);
        User::create([
            'name' => 'furchasing',
            'email' => 'furchasing@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'furchasing',
        ]);
        User::create([
            'name' => 'keuangan',
            'email' => 'keuangan@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'keuangan',
        ]);
        User::create([
            'name' => 'konten kreator',
            'email' => 'konten kreator@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'konten kreator',
        ]);
    }
}
