<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use SoftDeletes, HasUuids;
    protected $fillable = [
        'name',
        'attendance',
        'price',
        'currency',
        'ttype_id',
        'trole_id',
        'state_id',
        'study_id',
    ];

    public function user()
    {
        return $this->belongsToMany(User::class);
    }

    public function ttype()
    {
        return $this->belongsTo(Ttype::class)->withTrashed();
    }

    public function trole()
    {
        return $this->belongsTo(Trole::class)->withTrashed();
    }

    public function state()
    {
        return $this->belongsTo(Status::class)->withTrashed();
    }

    public function study()
    {
        return $this->belongsTo(Study::class);
    }
}
