<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;

class CommonController extends Controller
{
    public function getCountries()
    {
        $country = Country::all();

        return response()->json([
            'success' => false,
            'status' => 200,
            'message' => 'country list fetched successfully',
            'data' => $country,
        ], 200);
    }
}
