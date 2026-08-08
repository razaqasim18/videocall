<?php

namespace App\Models;

use App\Mail\AdminResetPasswordMail;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;

class Admin extends Authenticatable implements CanResetPasswordContract
{
    use Notifiable, CanResetPasswordTrait;

    protected $guarded = [];

    public function sendPasswordResetNotification($token): void
    {
        Mail::to($this->email)->send(new AdminResetPasswordMail($token, $this->email));
    }
}
