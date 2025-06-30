<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /* public function role()
    {
        return $this->hasOne(Role::class, 'id', 'roles_id');
    } */

    public function role()
    {
        return $this->belongsTo(Role::class, 'roles_id', 'id');
    }

    public function hasPermission($permissionName)
    {
        /* return $this->role
                && $this->role->permissions->contains('name', $permissionName); */
        return $this->role
        ? $this->role->permissions()->where('name', $permissionName)->exists()
        : false;
    }

    public function student()
    {
        return $this->hasOne(Student::class, 'users_id', 'id');
    }

    public function internshipRequests()
    {
        return $this->hasMany(InternshipRequest::class, 'users_id');
    }

}
