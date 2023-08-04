<?php

namespace App\Http\Controllers\admin;

use App\Factories\ReportFactory;
use App\Http\Controllers\Controller;
use App\Models\Receive;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function getReports($type, $period, Request $request)
    {

        $reportObjectRepo = "App\Repositories\Reports\\" . ucfirst($type) . "Report";
        $report = ReportFactory::makeReport($reportObjectRepo, new Receive(), 'admin.reports.index');
        $report->getData($period);

        return $report->renderView(['directory' => $request->directory]);
    }
}
