<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserWalletTransaction;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function walletTransaction()
    {
        $data = UserWalletTransaction::where('user_id', auth()->id())->get();

        return response()->json([
            'success' => false,
            'status' => 200,
            'message' => 'data has been fetched successfully',
            'data' => $data,
        ], 200);
    }

    public function updateProfilepicture(Request $request)
    {
        $request->validate([
            'media' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:2048'],
        ]);
        $profile = User::findorFail(auth()->id());
        $mediaPath = $request->file('media')->store('uploads/user', 'public');
        $profile->profile_image = $mediaPath;
        if ($profile->update()) {
            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'data is saved succesafully',
                'data' => $profile,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'status' => 403,
                'message' => 'Something went wrong',
            ], 403);
        }
    }

    public function updateProfile(Request $request)
    {
        $profile = User::findorFail(auth()->id());
        $profile->name = $request->name;
        $profile->dob = $request->dob;
        $profile->gender = $request->gender;
        $profile->interest = $request->interest;
        $profile->material_status = $request->material_status;
        if ($profile->update()) {
            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'data is saved succesafully',
                'data' => $profile,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'status' => 403,
                'message' => 'Something went wrong',
            ], 403);
        }

    }
}
