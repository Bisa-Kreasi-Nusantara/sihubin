<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Major;

class MajorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $majors = [
            [
                'name' => 'Teknik Komputer & Jaringan',
            ],
            [
                'name' => 'Teknik Bisnis dan Sepeda Motor',
            ],
            [
                'name' => 'Produksi Film',
            ],
        ];

        foreach ($majors as $major) {
            Major::firstOrCreate([
                'name' => $major['name'],
            ], 
            $major);
        }
    }
}
