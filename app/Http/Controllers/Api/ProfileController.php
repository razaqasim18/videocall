<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
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
                'profile' => $profile,
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
