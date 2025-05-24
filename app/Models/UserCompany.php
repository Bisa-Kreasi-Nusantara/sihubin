<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCompany extends Model
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
}
