<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('Categories')->insert([
        [
            'name' => 'Agama',
            'description' => 'agama',
        ],
        [
            'name' => 'Komik',
            'description' => 'Komik',
        ],
        [
            'name' => 'Sejarah',
            'description' => 'Sejarah',
        ],
        [
            'name' => 'Bisnis',
            'description' => 'Bisnis',
        ],
        [
            'name' => 'Teknologi',
            'description' => 'Teknologi',
        ]
        ]);
    }
}
