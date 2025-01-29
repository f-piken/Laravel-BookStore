<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        $user = User::find(1); // Ambil pengguna berdasarkan ID atau kriteria lainnya
        $seller = User::find(2); // Ambil pengguna berdasarkan ID atau kriteria lainnya
        $customer = User::find(3); // Ambil pengguna berdasarkan ID atau kriteria lainnya
    
        // Cek apakah role sudah ada, jika belum buat role
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'customer']);
        Role::firstOrCreate(['name' => 'seller']);

        $user->assignRole('admin');
        $seller->assignRole('seller');
        $customer->assignRole('customer');
    }
}

