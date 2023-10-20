<?php

namespace App\Http\Controllers\admin;

use App\Factories\ReportFactory;
use App\Http\Controllers\Controller;
use Exception;
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

    public function indexSelectDate(Request $request, $type)
    {

        $action =  route('reports.list', [
            'type' => $type,
            'period' => 'selected',
            'directory' => $request->directory,
        ]);
        $periodTitle = match($type){
            'receive'=>'وصولی‌ها',
            'installment'=>'مطالبات',
            default => throw new Exception('Period Title says: no valid type'),
        };
        return view('admin.reports.select-date', compact('type', 'action', 'periodTitle'));
    }
}
