<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'code'];

    public function submenus()
    {
        return $this->hasMany(Submenu::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
