<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticable;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticable
{
    use HasFactory;

    protected $fillable = [
        'role_id',
        'first_name',
        'last_name',
        'username',
        'email',
        'phone',
        'password',
        'verified'
    ];

    protected $hidden = ['password', 'remember_token'];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function hasRole(string $role): bool
    {

        return $this->role && $this->role->name === $role;
    }

    public function addresses()
    {
        return $this->hasMany(UserAddress::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'client_id');
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }
}
