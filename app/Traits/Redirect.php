<?php

namespace App\Traits;



trait Redirect
{
    protected  function redirect($route = null, $stay = null)
    {
        $stay = boolval($stay);
        if ($stay) {
            return back() ;
        }else{
            return redirect($route);
        }
    }
}
