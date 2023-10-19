<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Contract;
use App\Models\Customer;
use App\Models\Installment;
use App\Models\Receive;
use App\Services\ContractService;
use App\Services\ReceiveService;

// This class not used any more
class DashboardController extends Controller
{
    public function index(ContractService $contractService, Installment $installment, Receive $receive, ReceiveService $receiveService, Contract $contract, Customer $customer, Company $company)
    {
        $debtorContracts = $contract::whereHas('installments', function ($query) {
            $query->where('due_at', '<=', today())->where('status', 'billed')->where('collectible', true);
        })->get();

        $totalDebtor = number_format($debtorContracts->sum(function ($contract) use ($receiveService) {
            return fix_number($receiveService->getDetail($contract)['debtor']);
        }));


        $uncollectedChecks = $receive->uncollectedChecks()->with('contract')->get()->groupBy('due_at');

        $balance            = $contractService->getContractYearlyBalancePercent($contract);
        $balancePercent     = $balance['percent'];
        $balanceImprovement = $balance['improvement'];

        $contractsCount        = $contract::all()->count();
        $contractCanceledCount = $contract::where('contract_status', 'canceled')->get()->count();
        $customerCount         = $customer::all()->count();
        $companyCount          = $company::all()->count();

        return view(
            'admin.dashboard.index',
            compact(
                'debtorContracts',
                'totalDebtor',
                'customerCount',
                'uncollectedChecks',
                'balancePercent',
                'balanceImprovement',
                'contractsCount',
                'companyCount',
                'contractCanceledCount'
            )
        );
    }
}
