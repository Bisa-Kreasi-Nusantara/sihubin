<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternshipSchedule extends Model
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

    public function user_company()
    {
        return $this->hasMany(User::class, 'id', 'users_id');
    }

    public function acceptedWeighingResult()
    {
        return $this->hasOne(WeighingResult::class, 'users_id', 'users_id')
        ->where('status', 'accepted')
        ->whereColumn('companies_id', 'companies_id');
    }
}
