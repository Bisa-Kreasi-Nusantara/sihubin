<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

use App\Models\InternshipRequest;
use App\Models\User;
use App\Models\Company;

use Auth;

class InternshipRequestImport implements ToCollection, WithHeadingRow, WithChunkReading
{
    
    use Importable;

    public $errors = [];

    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {

            if (!$row['fullname']) {
                continue;
            }

            $user = User::where('fullname', $row['fullname'])->first();

            if (!$user) {
                $this->errors[] = "Row " . ($index + 1) . ": User '{$row['fullname']}' tidak ditemukan.";
                continue;
            }

            $company = Company::where('name', $row['requested_company'])->first();

            if (!$company) {
                $this->errors[] = "Row " . ($index + 1) . ": Perusahaan '{$row['requested_company']}' tidak ditemukan.";
                continue;
            }

            $users_id = $user->id;
            $companies_id = $company->id;
            $estimated_distance = $row['estimated_distance'];

            
            try {
                InternshipRequest::create([
                    'users_id'      => $user->id,
                    'companies_id'  => $company->id,
                    'estimated_distance' => $row['estimated_distance'],
                    'created_by'    => Auth::user()->id,
                ]);
            } catch (\Exception $e) {
                $this->errors[] = "Row " . ($index + 1) . ": Gagal menyimpan data. " . $e->getMessage();
            }

        }
    }

    public function chunkSize(): int
    {
        return 10;
    }
}
