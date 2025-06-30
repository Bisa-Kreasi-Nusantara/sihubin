<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\CriteriaWeight;

class CriteriaWeightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $criteria_weights = [
            [
                "name"          => "Kesesuaian Jurusan",
                "weight_value"  => 0.4,
                "type"          => "benefit",
            ],
            // [
            //     "name"          => "Jarak",
            //     "weight_value"  => 0.2,
            //     "type"          => "cost",
            // ],
            [
                "name"          => "Reputasi Industri",
                "weight_value"  => 0.25,
                "type"          => "benefit",
            ],
            [
                "name"          => "Kapasitas Industri",
                "weight_value"  => 0.1,
                "type"          => "benefit",
            ],
            [
                "name"          => "Nilai Akademik Siswa",
                "weight_value"  => 0.1,
                "type"          => "benefit",
            ],
        ];

        foreach ($criteria_weights as $row) {
            CriteriaWeight::firstOrCreate(
                ['name' => $row['name']],
                $row
            );
        }
    }
}
