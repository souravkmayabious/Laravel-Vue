<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       // Create an admin user with specific details
        User::create([
            'name' => 'sourav admin',
            'email' => 'souravk.mayabious@gmail.com', 
            'password' => Hash::make('12345678'), 
            'mobile' => '9874563210',
            'role' => 'admin', 
            'status' => 'verified'
        ]);
    }
}
