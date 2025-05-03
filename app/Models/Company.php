<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $guarded = [];
    public function major()
    {
        return $this->hasOne(Major::class, 'id', 'majors_id');
    }
}
