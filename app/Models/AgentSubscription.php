<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgentSubscription extends Model
{
    public $timestamps = false;
    protected $fillable = [ 'name', 'description', 'price', 'coins', 'is_active'];
}
