<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Submenu extends Model
{
    use SoftDeletes;
    protected $fillable = ['menu_id', 'name', 'url', 'icon', 'isActive'];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
