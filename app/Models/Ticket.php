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
        'ttype_id',
        'trole_id',
        'state_id',
        'study_id',
    ];

    public function ttype()
    {
        return $this->belongsTo(Ttype::class);
    }

    public function trole()
    {
        return $this->belongsTo(Trole::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function study()
    {
        return $this->belongsTo(Study::class);
    }
}
