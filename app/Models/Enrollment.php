<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'initiative_id',
        'enrolled_at',
    ];

    protected $casts = [
        'enrolled_at' => 'datetime',
    ];

    /**
     * Get the user who enrolled
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the initiative enrolled in
     */
    public function initiative()
    {
        return $this->belongsTo(Initiative::class);
    }
}
