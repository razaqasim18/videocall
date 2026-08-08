<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    public $timestamps = false;

    public function user(){
        return $this->hasMany(User::class);
    }
}
