<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        $user = User::find(1);
        $editor = User::find(2);
        $viewer = User::find(3);
    
        // Cek apakah role sudah ada, jika belum buat role
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'viewer']);
        Role::firstOrCreate(['name' => 'editor']);

        $user->assignRole('admin');
        $editor->assignRole('editor');
        $viewer->assignRole('viewer');
    }
}

