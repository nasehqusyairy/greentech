<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'attendance',
        'price',
        'type_id',
        'role_id',
        'state_id',
        'study_id',
    ];

    public function type()
    {
        return $this->belongsTo(Ttype::class);        
    }

    public function role()
    {
        return $this->belongsTo(Trole::class);
    }

    public function state()
    {
        return $this->belongsTo(Status::class);
    }

    public function study()
    {
        return $this->belongsTo(Study::class);
    }
}
