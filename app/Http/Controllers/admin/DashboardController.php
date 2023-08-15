<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Contract;
use App\Models\Customer;
use App\Models\Installment;
use App\Models\Receive;
use App\Repositories\Contract\ContractRepo;
use App\Services\ContractService;

class DashboardController extends Controller
{
    public function index( )
    {

        $debtorInstallments = (new Installment())->debtorInstallments()->with('contract')->paginate(30);
        $debtorInstallmentsGrouped = $debtorInstallments->groupBy('contract_id');
        $uncollectedChecks = (new Receive())->uncollectedChecks()->with('contract')->get()->groupBy('due_at');
        $balance = (new ContractService())->getContractYearlyBalancePercent();
        $balancePercent = $balance['percent'];
        $balanceImprovement = $balance['improvement'];
        $contractsCount = Contract::all()->count();
        $contractCanceledCount = Contract::where('contract_status', 'canceled')->get()->count();
        $customerCount = Customer::all()->count();
        $companyCount = Company::all()->count();
        return view('admin.dashboard.index', compact(
            'debtorInstallments',
            'debtorInstallmentsGrouped',
            'customerCount',
            'uncollectedChecks',
            'balancePercent',
            'balanceImprovement',
            'contractsCount',
            'companyCount',
            'contractCanceledCount'
        ));
    }
}
