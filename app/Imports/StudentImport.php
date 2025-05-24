<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

use App\Models\User;
use App\Models\Student;
use App\Models\Major;
use App\Models\Role;

use Hash;
use Auth;

class StudentImport implements ToCollection, WithHeadingRow, WithChunkReading
{

    use Importable;

    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $major = Major::where('name', $row['jurusan'])->first();
            $role = Role::where('name', 'student')->first();

            if (!$major) {
                continue;
            }


            $fullname   = $row['fullname'];
            $nis        = $row['nis'];
            $address    = $row['address'];
            $avg_scores = $row['avg_scores'];
            $major_id      = $major->id;
            $email      = $row['email'];
            $password   = Hash::make($row['password']);

            $user = User::firstOrCreate(
            [
                'fullname' => $fullname,
                'email'    => $email,
            ],    
            [
                'roles_id' => $role->id,
                'fullname' => $fullname,
                'email'    => $email,
                'password' => $password,
                'created_by' => Auth::user()->id,
            ]);

            Student::firstOrCreate(
            [
                'users_id'  => $user->id,
                'nis'       => $nis,
            ],
            [
                'users_id'  => $user->id,
                'majors_id' => $major_id,
                'nis'       => $nis,
                'avg_scores'    => $avg_scores,
                'address'    => $address,
                'created_by' => Auth::user()->id,
            ]);
        }
    }

    public function chunkSize(): int
    {
        return 10;
    }
}
