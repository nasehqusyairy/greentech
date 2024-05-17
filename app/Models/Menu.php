<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'code', 'order'];

    public function submenus()
    {
        return $this->hasMany(Submenu::class)->withTrashed();
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTrashed();
    }
}
