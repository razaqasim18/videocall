<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    public $timestamps = false;

    protected $fillable = ['name', 'description', 'price', 'duration_days', 'is_active', 'is_feature'];

    public function user()
    {
        return $this->hasMany(User::class);
    }
}
