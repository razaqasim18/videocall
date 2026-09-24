<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DailyReward;
use App\Models\DailyRewardClaim;
use Illuminate\Http\Request;

class DailyRewardController extends Controller
{
    public function list()
    {

        $dailyrewards = DailyReward::active()
            ->withExists(['claims' => function ($query) {
                $query->where('user_id', auth()->id());
            }])
            ->get();
        $message = ($dailyrewards) ? 'data is saved succesafully' : 'No record found';
        $success = ($dailyrewards) ? true : false;

        return response()->json([
            'success' => $success,
            'status' => 200,
            'message' => $message,
            'data' => $dailyrewards,
        ], 200);
    }

    public function claim(Request $request)
    {
        $dailyReward = DailyRewardClaim::firstOrCreate([
            'user_id' => auth()->id(),
            'daily_reward_id' => $request->daily_reward_id,
        ]);

        if (! $dailyReward->wasRecentlyCreated) {
            return response()->json([
                'success' => false,
                'status' => 409,
                'message' => 'Reward already claimed.',
            ], 409);
        }

        return response()->json([
            'success' => true,
            'status' => 200,
            'message' => 'Reward claimed successfully.',
            'data' => $dailyReward,
        ]);
    }
}
