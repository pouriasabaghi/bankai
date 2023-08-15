<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Installment;
use App\Models\Receive;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {
        $debtorInstallments = (new Installment())->debtorInstallments()->with('contract')->paginate(10);
        $debtorInstallmentsGrouped = $debtorInstallments->groupBy('contract_id');
        $uncollectedChecks = (new Receive())->uncollectedChecks()->with('contract')->get()->groupBy('due_at');
        return view('admin.dashboard.index', compact('debtorInstallments', 'debtorInstallmentsGrouped', 'uncollectedChecks'));
    }
}
