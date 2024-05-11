<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Abstrac extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'title',
        'authors',
        'emails',
        'text',
        'file',
        'status_id',
        'creator_id',
        'topic_id',
        'reviewer_id',
    ];
    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
