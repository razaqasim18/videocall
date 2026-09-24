<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyReward extends Model
{
    // These are the settings for the reward itself
    protected $fillable = ['coins', 'days', 'is_active'];

    /**
     * A specific reward template (e.g., Day 1) can be claimed by many users.
     */
    public function claims()
    {
        return $this->hasMany(DailyRewardClaim::class, 'daily_reward_id');
    }

    /**
     * Scope to only get rewards that are currently active.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
