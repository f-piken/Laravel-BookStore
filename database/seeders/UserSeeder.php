<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Seller;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'photo' => 'images/default.jpg',
        ]);

        // Sales User
        $seller = User::create([
            'name' => 'Seller User',
            'email' => 'seller@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'seller',
            'photo' => 'images/default.jpg',
        ]);

        // Customer User
        $customer = User::create([
            'name' => 'Customer User',
            'email' => 'customer@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'customer',
            'photo' => 'images/default.jpg',
        ]);

        Customer::create([
            'user_id'=>$customer->id,
        ]);
        Seller::create([
            'user_id'=>$seller->id,
        ]);
    }
}
