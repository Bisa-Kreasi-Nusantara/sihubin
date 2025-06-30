<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use DB;

class WeighingResult extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'users_id');
    }

    public function company()
    {
        return $this->hasOne(Company::class, 'id', 'companies_id');
    }

    public function proceedBy()
    {
        return $this->hasOne(User::class, 'id', 'proceed_by');
    }

    public static function generateCode()
    {
        // Ambil kode terakhir yang ada di tabel WeighingResults
        $lastCode = self::orderBy('created_at', 'desc')
                        ->pluck('code')
                        ->first();

        // Ambil nomor urut dari kode terakhir, jika ada
        $lastNumber = $lastCode ? (int) substr($lastCode, 4) : 0;

        // Increment nomor urut
        $nextNumber = $lastNumber + 1;

        // Format nomor urut menjadi 4 digit
        $formattedNumber = str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        // Gabungkan dengan prefix "SPK-"
        return "SPK-" . $formattedNumber;
    }
}
