<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Abstrac extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'title',
        'author',
        'email',
        'text',
        'creator_id',
        'topic_id',
        'reviewer_id',
    ];
    public function creator()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class)->withTrashed();
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }
}
