<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'phone',
        'country',
        'callingcode',
        'institution',
        'gender',
        'role_id',
        'resetPasswordCode',
        'activationCode',
        'isActive',
    ];

    protected $hidden = ['password'];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
