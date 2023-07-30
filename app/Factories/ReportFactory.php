<?php namespace App\Factories;


class ReportFactory{
    public static function makeReport($report, $data, $view){
        return new $report($data, $view);
    }
}
