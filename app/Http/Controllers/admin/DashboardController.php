<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Contract;
use App\Models\Customer;
use App\Models\Installment;
use App\Models\Receive;
use App\Services\ContractService;

class DashboardController extends Controller
{
    public function index(ContractService $contractService, Installment $installment, Receive $receive )
    {

        $debtorInstallments = $installment->debtorInstallments()->with('contract')->get();
        $totalDebtor =  number_format($debtorInstallments->sum('amount'));
        $debtorInstallmentsGrouped = $debtorInstallments->groupBy('contract_id');

        $uncollectedChecks = $receive->uncollectedChecks()->with('contract')->get()->groupBy('due_at');

        $balance = $contractService->getContractYearlyBalancePercent(new Contract());
        $balancePercent = $balance['percent'];
        $balanceImprovement = $balance['improvement'];

        $contractsCount = Contract::all()->count();
        $contractCanceledCount = Contract::where('contract_status', 'canceled')->get()->count();
        $customerCount = Customer::all()->count();
        $companyCount = Company::all()->count();

        return view('admin.dashboard.index', compact(
            'debtorInstallments',
            'totalDebtor',
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
