<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Major;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $majors = Major::all();

        foreach ($majors as $major) {
            for ($i = 1; $i <= 10; $i++) {

                Company::firstOrCreate(
                [
                    'majors_id'   => $major->id,
                    'name'        => "Perusahaan {$major->name} {$i}",
                ],    
                [
                    'majors_id'   => $major->id,
                    'name'        => "Perusahaan {$major->name} {$i}",
                    'address'     => "Alamat Perusahaan {$i}",
                    'max_capacity'=> rand(5, 20),
                    'reputations' => rand(1, 5),
                    'start_date'  => now()->subMonths(rand(1, 6)),
                    'end_date'    => now()->addMonths(rand(1, 6)),
                    'is_active'   => true,
                    'created_by'  => 1,
                    'updated_by'  => 1,
                ]);
            }
        }
    }
}
