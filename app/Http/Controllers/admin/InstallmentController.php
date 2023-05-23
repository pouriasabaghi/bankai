<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Services\InstallmentService;
use Illuminate\Http\Request;

class InstallmentController extends Controller
{
    protected InstallmentService $service;
    public function __construct()
    {
        $this->service = new InstallmentService();
    }
    public function create(Contract $contract)
    {
        $service = $this->service;
        $formAttributes = $service->formAttributes($contract);
        $contractInstallments = $contract->installments;
        $emptyInstallments = range($contractInstallments->count(), 50 - $contractInstallments->count());
        $installments = collect($contractInstallments)->merge($emptyInstallments);


        $totalPrice = intval($contract->total_price);
        $installmentCount = intval(fix_number($contract->period)) ?? 1;
        $installmentAmount = floor($totalPrice / $installmentCount); // every installment without any rest
        $installmentAmount =  $installmentAmount - (intval($installmentAmount) % 500000); // step is 100 thousand
        $remainingAmount = $totalPrice - ($installmentAmount * ($installmentCount - 1));  // last installment amount;

        $ins = array_fill(0, $installmentCount - 1, intval($installmentAmount)); // normal installment amount
        $ins[] = intval($remainingAmount); // last installment

        return view('admin.installments.create', compact('contract', 'installments', 'installmentCount', 'formAttributes', 'ins'));
    }

    public function store(Request $request, Contract $contract)
    {
    }
}
