<?php

namespace App\Models;

use App\Models\Scopes\TopicClassroomScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Topic extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name', 'classroom_id', 'user_id'
    ];

    public function classworks(): HasMany
    {
        return $this->hasMany(Classwork::class);
    }

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }
    protected static function booted()
    {
        // static::addGlobalScope(new TopicClassroomScope);
    }
}
