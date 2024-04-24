<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['name'];

    public function submenus()
    {
        return $this->hasMany(Submenu::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
