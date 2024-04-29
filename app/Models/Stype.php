<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stype extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'code',
        'name'
    ];
}
