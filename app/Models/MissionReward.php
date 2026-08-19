<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MissionReward extends Model
{
    public $timestamps = false;

    protected $fillable = ['mission', 'task', 'coin', 'is_active'];
}
