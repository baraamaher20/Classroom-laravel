<?php

namespace App\Models;

use App\Models\Scopes\UserClassroomScope;
use App\Observers\ClassroomObserver;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Classroom extends Model
{
    use HasFactory, SoftDeletes;

    public static $disk = 'public';

    protected $fillable = [
        'name', 'section', 'subject', 'room', 'code', 'theme', 'cover_image_path', 'user_id'
    ];

    protected static function booted()
    {
        static::addGlobalScope(new UserClassroomScope);
        static::observe(ClassroomObserver::class);
    }


    public function classworks(): HasMany
    {
        return $this->hasMany(Classwork::class);
    }
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot([]);
    }

    public function teachers(): BelongsToMany
    {
        return $this->users()->wherePivot('role', 'teacher');
    }

    public function students(): BelongsToMany
    {
        return $this->users()->wherePivot('role', 'student');
    }

    public function scopeActive(Builder $query)
    {
        $query->where('status', 'active');
    }

    public function join($user_id, $role = 'student')
    {
        return $this->users()->attach($user_id, [
            'role' => $role,
            'created_at' => now(),
        ]); //insert in pivot
    }

    public function getNameAttribute($value)
    {
        return ucfirst(strtolower($value));
    }

    public function getCoverImageUrlAttribute()
    {
        if ($this->cover_image_path) {
            return Storage::disk('public')->url($this->cover_image_path);
        }
        return 'https://placehold.co/444x110';
    }
}
