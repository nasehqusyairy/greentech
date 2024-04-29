<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Study extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'code',
        'name'
    ];
}
