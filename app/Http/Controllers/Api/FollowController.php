<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $user = User::findOrFail($request->user_id);

        // Prevent following yourself
        if ($user->id == auth()->id()) {
            return response()->json([
                'success' => false,
                'status' => 422,
                'message' => 'You cannot follow yourself.',
            ], 422);
        }

        // Prevent duplicate follow
        $alreadyFollowing = Follow::where([
            'follower_id' => auth()->id(),
            'following_id' => $user->id,
        ])->exists();

        if ($alreadyFollowing) {
            return response()->json([
                'success' => false,
                'status' => 409,
                'message' => 'You are already following this user.',
            ], 409);
        }

        $follow = Follow::create([
            'follower_id' => auth()->id(),
            'following_id' => $user->id,
        ]);

        return response()->json([
            'success' => true,
            'status' => 200,
            'message' => 'User followed successfully.',
            'data' => $follow,
        ], 200);
    }

    public function remove(Request $request)
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $follow = Follow::where([
            'follower_id' => auth()->id(),
            'following_id' => $request->user_id,
        ])->first();

        if (! $follow) {
            return response()->json([
                'success' => false,
                'status' => 404,
                'message' => 'You are not following this user.',
            ], 404);
        }

        $follow->delete();

        return response()->json([
            'success' => true,
            'status' => 200,
            'message' => 'User unfollowed successfully.',
        ], 200);
    }
}
