<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketUser extends Model
{
    use SoftDeletes, HasUuids;
    protected $fillable = [
        'proof',
        'attachment',
        'status_id',
        'user_id',
        'ticket_id'
    ];

    protected $table = 'ticket_user';

    public function abstrac()
    {
        return $this->belongsTo(Abstrac::class)->withTrashed();
    }

    public function status()
    {
        return $this->belongsTo(Status::class)->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class)->withTrashed();
    }
}
