<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionCategory;

class SubscriptionController extends Controller
{
    public function list()
    {
        $data = SubscriptionCategory::with('subscription')->active()->get();

        return response()->json([
            'success' => true,
            'status' => 200,
            'message' => 'data is saved succesafully',
            'data' => $data,
        ], 200);

    }
}
