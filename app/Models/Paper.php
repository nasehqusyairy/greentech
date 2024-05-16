<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paper extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'file',
        'provement',
        'status_id',
        'abstrac_id',
        'publication_id',
    ];
    public function status()
    {
        return $this->belongsTo(Status::class)->withTrashed();
    }

    public function abstrac()
    {
        return $this->belongsTo(Abstrac::class)->withTrashed();
    }

    public function publication()
    {
        return $this->belongsTo(Publication::class)->withTrashed();
    }
}
