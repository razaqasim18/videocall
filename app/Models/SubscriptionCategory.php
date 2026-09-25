<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionCategory extends Model
{
    public $timestamps = false;

    protected $fillable = ['name', 'is_active'];

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function subscription()
    {
        return $this->hasMany(Subscription::class);
    }
}
