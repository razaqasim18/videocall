<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'name',
    'email',
    'password',
    'profile_image',
    'fcm_token',
    'coins',
    'gender',
    'is_online',
    'is_blocked',
    'is_verified',
    'is_subscribed',
    'subscription_id'
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * IMPORTANT: Added boolean casts so that 0/1 from database
     * becomes true/false in your Livewire components.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_online' => 'boolean',
            'is_blocked' => 'boolean',
            'is_verified' => 'boolean',
            'is_subscribed' => 'boolean',
            'gender' => 'integer',
            'coins' => 'integer',
        ];
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
}
