<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;

class SettingController extends Controller
{
    public function privacyPolicy()
    {
        $policy = Setting::where('key', 'privacy_policy')->first();

        return response()->json([
            'success' => true,
            'status' => 200,
            'message' => 'privacy & policy is fetched successfully',
            'data' => $policy,
        ], 200);
    }

    public function termCondition()
    {
        $policy = Setting::where('key', 'term_condition_policy')->first();

        return response()->json([
            'success' => true,
            'status' => 200,
            'message' => 'term & condition is fetched successfully',
            'data' => $policy,
        ], 200);
    }
}
