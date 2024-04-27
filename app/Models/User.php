<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;
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
