<?php

namespace App\Helpers;

use App\Models\Setting;

class CustomHelpers
{
    public static function settingByKey($key)
    {
        $result = Setting::where('key', $key)->first();

        return $result?->value ?? 0;
    }
}
