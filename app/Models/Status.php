<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Status extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'code',
        'text',
        'color',
        'name',
        'type_id'
    ];
    public function stype()
    {
        return $this->belongsTo(Stype::class)->withTrashed();
    }
}
