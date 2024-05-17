<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Submenu extends Model
{
    use SoftDeletes;
    protected $fillable = ['code', 'menu_id', 'name', 'url', 'icon', 'is_path'];

    public function menu()
    {
        /**@disregard */
        return $this->belongsTo(Menu::class)->withTrashed();
    }
}
