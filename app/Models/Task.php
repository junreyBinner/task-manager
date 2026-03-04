<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'is_done',
        'scheduled_at',
    ];

    protected $casts = [
        'is_done'      => 'boolean',
        'scheduled_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
