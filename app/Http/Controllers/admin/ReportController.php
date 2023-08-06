<?php

namespace App\Http\Controllers\admin;

use App\Factories\ReportFactory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function getReports(Request $request, $type, $period = null)
    {
        $reportObjectRepo = "App\Repositories\Reports\\" . ucfirst($type) . "Report";
        $model = "App\Models\\" . ucfirst($type);
        $report = ReportFactory::makeReport($reportObjectRepo, new $model, 'admin.reports.index');
        $report->getData($period);

        return $report->renderView(['directory' => $request->directory]);
    }
}
