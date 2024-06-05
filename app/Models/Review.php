<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'file',
        'comment',
        'abstrac_id',
        'status_id'
    ];
    public function abstrac()
    {
        return $this->belongsTo(Abstrac::class)->withTrashed();
    }

    public function status()
    {
        return $this->belongsTo(Status::class)->withTrashed();
    }
}
