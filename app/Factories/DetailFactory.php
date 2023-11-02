<?php namespace App\Factories;

use Throwable;

class DetailFactory{
    public static function makeDetail($detail, $data, $view){
        try{
            return new $detail($data, $view);
        }catch(Throwable $e){
              dd('Error Message: did not find related detail class. class name must be singular', $e->getMessage());
        }
    }
}
