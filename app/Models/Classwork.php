<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classwork extends Model
{
    use HasFactory;

    const TYPE_ASSIGNMENT = 'assignment';
    const TYPE_MATERIAL = 'material';
    const TYPE_QUESTION = 'question';
    const TYPE_PUBLISHED = 'published';
    const TYPE_DRAFT = 'draft';

    protected $fillable = [
        'classroom_id', 'user_id', 'topic_id', 'title',
        'description', 'type', 'status', 'options', 'published_at',
    ];

    protected $casts = [
        'options' => 'json',
        'published_at' => 'date'
    ];

    public function getPublishedDateAttribute()
    {
        if ($this->published_at) {
            return $this->published_at->format('Y-m-d');
        }
    }

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }
    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class)->withDefault();
    }
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withPivot('grade', 'submitted_at', 'status', 'created_at')
            ->using(ClassworkUser::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->latest();
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class);
    }
}
