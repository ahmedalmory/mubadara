<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'initiative_id',
        'title',
        'description',
        'points_value',
        'status',
        'order',
    ];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
        'points_value' => 'integer',
        'order' => 'integer',
    ];

    /**
     * Get the localized title
     */
    public function getLocalizedTitle(): string
    {
        $locale = app()->getLocale();
        return $this->title[$locale] ?? $this->title['en'] ?? '';
    }

    /**
     * Get the localized description
     */
    public function getLocalizedDescription(): string
    {
        $locale = app()->getLocale();
        return $this->description[$locale] ?? $this->description['en'] ?? '';
    }

    /**
     * Get the initiative this task belongs to
     */
    public function initiative()
    {
        return $this->belongsTo(Initiative::class);
    }

    /**
     * Get completions for this task
     */
    public function completions()
    {
        return $this->hasMany(TaskCompletion::class);
    }

    /**
     * Check if task is completed by a specific user
     */
    public function isCompletedBy($userId): bool
    {
        return $this->completions()->where('user_id', $userId)->exists();
    }

    /**
     * Get completion for a specific user
     */
    public function getCompletionFor($userId)
    {
        return $this->completions()->where('user_id', $userId)->first();
    }

    /**
     * Scope for active tasks
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
