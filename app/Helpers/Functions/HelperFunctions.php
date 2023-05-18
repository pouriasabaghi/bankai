<?php

use Carbon\Carbon;
use Illuminate\Http\Request;


// ? get site content by key name
/* if (!function_exists('get_field')) {
    function get_field($key)
    {
        $value =   App\Models\Setting::query()->where('meta_key', $key)->first();
        if ($value) {
            return $value->meta_value;
        }
        return null;
    }
} */

// ? check if  current route is active
if (!function_exists('is_route_active')) {
    function is_route_active(...$route)
    {
        if (in_array(request()->route()->getName(), $route)) {
            return true;
        }

        return false;
    }
}

// ? convert arabic and persian number to english
if(!function_exists('fix_number')){
    function fix_number($number) {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $arabic = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];

        $num = range(0, 9);
        $convertedPersianNums = str_replace($persian, $num, $number);
        $englishNumbersOnly = str_replace($arabic, $num, $convertedPersianNums);

        return $englishNumbersOnly;
    }
}


if(!function_exists('get_device')){
    function get_device(Request $request) : string
    {
        $userAgent = $request->header('User-Agent');

        $devices = [
            'iPhone' => 'iPhone',
            'iPad' => 'iPad',
            'Android' => 'Android',
            'Windows Phone' => 'Windows Phone',
            'Windows' => 'Windows NT',
            'Macintosh' => 'Macintosh',
            'Linux' => 'Linux'
        ];

        $device = 'Unknown';
        foreach ($devices as $key => $value) {
            if (strpos($userAgent, $value)) {
                $device = $key;
                break;
            }
        }

        return $device;
    }
}
