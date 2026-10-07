<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function list(Request $request)
    {
        $userId = auth()->id();
        $limit = $request->input('limit', 10);
        $selectedUser = User::findOrFail($userId);

        // Show opposite gender
        $selectGender = $selectedUser->gender === 'male'
            ? 'female'
            : 'male';

        $query = User::where('id', '!=', $userId)
            ->where('gender', $selectGender);

        // Filter by country if provided
        if ($request->filled('country_id')) {
            $query->where('country_id', $request->country_id);
        }
        $users = $query->paginate($limit);

        return response()->json([
            'success' => true,
            'status' => 200,
            'message' => 'User list is fetched successfully',
            'data' => $users->items(),
            'pagination' => [
                'current_page' => $users->currentPage(),
                'last_page' => $users->lastPage(),
                'per_page' => $users->perPage(),
                'total' => $users->total(),
                'has_more' => $users->hasMorePages(),
            ],
        ], 200);
    }
}
