<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Services\InstallmentService;
use App\Traits\Alert;
use App\Traits\Redirect;
use Exception;
use Illuminate\Http\Request;


class InstallmentController extends Controller
{
    use Alert, Redirect;
    protected InstallmentService $service;
    public function __construct()
    {
        $this->service = new InstallmentService();
    }
    public function create(Contract $contract)
    {
        $service = $this->service;
        $formAttributes = $service->formAttributes($contract);


        $installments = $service->prepareInstallments($contract->installments);


        // it's update form and contract didn't need auto installment calculate ;
        if (!$contract->installments->isEmpty()) {
            $installmentsCount = -1;
            $installmentsAmount = [];
        } else {
            list($installmentsAmount, $installmentsCount) = $service->calculateInstallments($contract->total_price, $contract->period);
        }

        return view('admin.installments.create', compact('contract', 'installments', 'formAttributes', 'installmentsCount', 'installmentsAmount'));
    }

    public function store(Request $request, Contract $contract)
    {
        try {
            $service = $this->service;
            $installments = $request->installment;
            $installments = $service->removeUnusedInstallments($installments);
            $service->sumInstallments($installments)->validate($contract->total_price);
            $service->sync($installments, $contract);
            $this->successAlert(null, 'اقساط با موفقیت ثبت شد');
            return $this->redirect(route('receives.create', $contract)) ;
        } catch (Exception $exception) {
            return back()->withErrors($exception->getMessage());
        }
    }
}
