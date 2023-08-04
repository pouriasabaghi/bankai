<?php namespace App\Factories;

use Throwable;

class ReportFactory{
    public static function makeReport($report, $data, $view){
        try{
            return new $report($data, $view);
        }catch(Throwable $e){
              dd('Error Message: did not find related report class. class name must be singular');
        }
    }
}
