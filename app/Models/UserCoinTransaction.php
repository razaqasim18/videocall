<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCoinTransaction extends Model
{
    public $fillable =
        [
            'user_id',
            'status',
            'type',
            'coins',
            'coin_before',
            'coin_after',
            'description',
        ];
}
