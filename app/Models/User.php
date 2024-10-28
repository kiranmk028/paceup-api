<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'email',
        'password',
        'country_code',
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

    public function metaData(): HasOne
    {
        return $this->hasOne(UserMetaData::class);
    }

    public function country(): HasOne
    {
        return $this->hasOne(Country::class);
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(Invitation::class);
    }

    public function latestInvitation(): HasOne
    {
        // return $this->invitations()->one()->ofMany('created_at', 'min');
        return $this->hasOne(Invitation::class)->lastestOfMany();
    }

    // public function currentPricing(): HasOne
    // {
    //     return $this->hasOne(Price::class)->ofMany([
    //         'published_at' => 'max',
    //         'id' => 'max',
    //     ], function (Builder $query) {
    //         $query->where('published_at', '<', now());
    //     });
    // }

    public function workspaces(): HasMany
    {
        return $this->hasMany(Workspace::class);
    }

    public function invitedWorkspaces(): BelongsToMany
    {
        return $this->belongsToMany(Workspace::class);
    }

    public function folders(): HasMany
    {
        return $this->hasMany(Folder::class);
    }

    public function spaces(): HasMany
    {
        return $this->hasMany(Space::class);
    }

    public function invitedSpaces(): BelongsToMany
    {
        return $this->belongsToMany(Space::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function assignedTasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class);
    }
}
