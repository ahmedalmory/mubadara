<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TaskCompletion extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'task_id',
        'completed_by',
        'points_awarded',
        'notes',
        'completed_at',
    ];

    protected $casts = [
        'points_awarded' => 'integer',
        'completed_at' => 'datetime',
    ];

    /**
     * Get the student who completed the task
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the task that was completed
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Get the admin who marked the task as completed
     */
    public function completedBy()
    {
        return $this->belongsTo(User::class, 'completed_by');
    }

    /**
     * Boot method to automatically update user's total points
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($completion) {
            $completion->user->updateTotalPoints();
        });

        static::deleted(function ($completion) {
            $completion->user->updateTotalPoints();
        });
    }
}
