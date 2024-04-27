<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use SoftDeletes;

    protected $fillable = ['path'];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
