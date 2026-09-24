<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyRewardClaim extends Model
{
    // These fields must be fillable so you can use DailyRewardClaim::create([...])
    protected $fillable = ['user_id', 'daily_reward_id', 'claimed_at'];

    /**
     * Get the user who claimed this reward.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the reward details for this claim.
     */
    public function reward()
    {
        return $this->belongsTo(DailyReward::class, 'daily_reward_id');
    }
}
