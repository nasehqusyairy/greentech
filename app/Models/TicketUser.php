<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketUser extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'file',
        'student_card',
        'status_id',
        'abstract_id',
        'user_id',
        'ticket_id'        
    ];

    public function abstrac()
    {
        return $this->belongsTo(Abstrac::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }


}