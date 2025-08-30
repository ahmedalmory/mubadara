<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Initiative extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'is_active',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'name' => 'array',
        'description' => 'array',
        'is_active' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Get the localized name
     */
    public function getLocalizedName(): string
    {
        $locale = app()->getLocale();
        return $this->name[$locale] ?? $this->name['en'] ?? '';
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
     * Get the category this initiative belongs to
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get tasks belonging to this initiative
     */
    public function tasks()
    {
        return $this->hasMany(Task::class)->orderBy('order');
    }

    /**
     * Get enrollments for this initiative
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Get students enrolled in this initiative
     */
    public function students()
    {
        return $this->belongsToMany(User::class, 'enrollments');
    }

    /**
     * Check if a user is enrolled in this initiative
     */
    public function isUserEnrolled($userId): bool
    {
        return $this->enrollments()->where('user_id', $userId)->exists();
    }

    /**
     * Get total points available for this initiative
     */
    public function getTotalPointsAttribute(): int
    {
        return $this->tasks()->sum('points_value');
    }

    /**
     * Scope for active initiatives
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
