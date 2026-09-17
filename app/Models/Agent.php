<?php

namespace App\Models;

use App\Mail\ResetPasswordMail;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;

class Agent extends Authenticatable implements CanResetPasswordContract
{
    use CanResetPasswordTrait, Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function sendPasswordResetNotification($token): void
    {
        Mail::to($this->email)->send(
            new ResetPasswordMail(
                $token,
                $this->email,
                'agent'
            )
        );
    }

    public function walletTransaction(): HasMany
    {
        return $this->hasMany(AgentWalletTransaction::class);
    }

    public function agentTransaction(): HasMany
    {
        return $this->hasMany(AgentPackageTransaction::class);
    }
}
