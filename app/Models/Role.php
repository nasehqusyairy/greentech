<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'code'];

    public function users()
    {
        return $this->hasMany(User::class)->withTrashed();
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class)->withTrashed()->orderBy('order');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class)->withTrashed();
    }
}
