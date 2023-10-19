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
if (!function_exists('is_url_active')) {
    /**
     * @param string|array|callable $route | can be callable that return boolean, can be string that contains in url, can be array of name to check with current route name
     * @param mixed $routes | loop and check if current route name contain passed value
     * @return bool
     */
    function is_url_active($mixed, ...$routes): bool
    {
        if (is_callable($mixed)) {
            return $mixed();
        }

        if (is_string($mixed)) {
            return strpos(request()->fullUrl(), $mixed);
        }

        if (is_array($mixed)) {
            return in_array(request()->route()->getName(), $mixed);
        }


        foreach ($routes as $route) {
            if (strpos(request()->fullUrl(), $route) !== false) {
                return true;
            }
        }

        return false;
    }
}



// ? convert arabic and persian number to english
if (!function_exists('fix_number')) {
    function fix_number($number)
    {
        $number = $number ?? 0;
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $arabic = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];

        $num = range(0, 9);
        $removeSeparate = str_replace(',', '', $number);
        $convertedPersianNums = str_replace($persian, $num, $removeSeparate);
        $englishNumbersOnly = str_replace($arabic, $num, $convertedPersianNums);

        return $englishNumbersOnly;
    }
}


if (!function_exists('get_device')) {
    function get_device(Request $request): string
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
