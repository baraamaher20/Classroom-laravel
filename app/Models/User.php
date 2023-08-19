<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];



    //The New Way
    protected function email(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucfirst(strtolower($value)),
            set: fn ($value) => strtoupper($value),
        );
    }

    //The Old Way
    // public function setEmailAttribute($value)
    // {
    //     $this->attributes['email'] = strtoupper($value);
    // }

    public function classrooms(): BelongsToMany
    {
        return $this->belongsToMany(Classroom::class);
    }

    public function createdCalssroom(): HasMany
    {
        return $this->hasMany(Classroom::class, 'user_id'); //who is owner
    }

    public function classworks(): BelongsToMany
    {
        return $this->belongsToMany(Classwork::class)
            ->withPivot('grade', 'submitted_at', 'status', 'created_at')
            ->using(ClassworkUser::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function submissions():HasMany
    {
        return $this->hasMany(Submission::class);
    }
}