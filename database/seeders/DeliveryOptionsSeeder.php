<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeliveryOptionsSeeder extends Seeder
{
    public function run()
    {
        // Menambahkan data ke tabel delivery_options
        DB::table('delivery_options')->insert([
            [
                'name' => 'JNE',
                'code' => 'jne',
                'estimate' => '2-3 Days',
                'cost' => 15000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'TIKI',
                'code' => 'tiki',
                'estimate' => '3-5 Days',
                'cost' => 13000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Gojek',
                'code' => 'gojek',
                'estimate' => '1-2 Days',
                'cost' => 20000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'SiCepat',
                'code' => 'sicepat',
                'estimate' => '3-4 Days',
                'cost' => 18000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'POS Indonesia',
                'code' => 'pos',
                'estimate' => '4-6 Days',
                'cost' => 12000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
