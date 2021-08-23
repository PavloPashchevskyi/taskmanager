<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'body',
        'due_date',
        'attachment_path',
        'complete',
        'remind_executor_in',
        'creator_id',
        'executor_id',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    public function executor()
    {
        return $this->belongsTo(User::class);
    }
}
