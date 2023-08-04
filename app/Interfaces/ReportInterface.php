<?php

namespace App\Interfaces;

interface ReportInterface{
    public function getData($period) ;
    public function renderView();
}
