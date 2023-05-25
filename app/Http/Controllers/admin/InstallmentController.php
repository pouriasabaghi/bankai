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
        $installments = $service->prepareInstallments($contract->installments);
        list($installmentsAmount, $installmentsCount) = $service->calculateInstallments($contract->total_price, $contract->period);

        return view('admin.installments.create', compact('contract', 'installments', 'installmentsCount', 'formAttributes', 'installmentsAmount'));
    }

    public function store(Request $request, Contract $contract)
    {
    }
}
