<?php

namespace App\Helpers\Functions;

use Illuminate\Support\ServiceProvider;

class HelperFunctionsServiceProvider extends ServiceProvider{

    public function register()
    {
        $file = app_path('Helpers/Functions/HelperFunctions.php');
        if (file_exists($file)) {
            require_once($file);
        }
    }
}
