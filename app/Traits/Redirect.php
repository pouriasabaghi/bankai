<?php

namespace App\Traits;



trait Redirect
{
    protected  function redirect($route = null)
    {
        $stay = request()->stay_in_page ?? false;
        if (boolval($stay)) {
            return back();
        } else {
            return redirect($route);
        }
    }
}
