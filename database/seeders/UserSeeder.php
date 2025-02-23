<?php

namespace Database\Seeders;

use App\Models\viewer;
use App\Models\editor;
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
        $editor = User::create([
            'name' => 'Editor User',
            'email' => 'editor@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'editor',
            'photo' => 'images/default.jpg',
        ]);

        // viewer User
        $viewer = User::create([
            'name' => 'Viewer User',
            'email' => 'viewer@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'viewer',
            'photo' => 'images/default.jpg',
        ]);

        viewer::create([
            'user_id'=>$viewer->id,
        ]);
        editor::create([
            'user_id'=>$editor->id,
        ]);
    }
}
