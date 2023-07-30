<?php

namespace App\Http\Controllers\Admin;

use App\Factories\ReportFactory;
use App\Http\Controllers\Controller;
use App\Models\Installment;
use App\Repositories\Reports\ReceiveReport;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function getReports(){

    $reports = ReportFactory::makeReport(ReceiveReport::class, Installment::query(), 'admin.dashboard');
    dd($reports->getData());
    }
}
