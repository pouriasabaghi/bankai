<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\Company;
use App\Models\Contract;
use App\Services\InstallmentService;
use App\Services\ReceiveService;
use App\Traits\Alert;
use Exception;
use Illuminate\Http\Request;

class ReceiveController extends Controller
{
    use Alert;
    private ReceiveService $service;
    public function __construct()
    {
        $this->service = new ReceiveService();;
    }
    public function create(Contract $contract)
    {
        if (!$this->valid($contract)) {
            return redirect(route('installments.create', $contract->id))->withErrors('ابتدا اقساط را تعریف و ذخیره کنید');
        }
        $service = $this->service;
        $cards = Card::query()->latest()->get();
        $companies =  $contract->customer->companies;
        $formAttributes = $service->formAttributes($contract);
        $receives = $contract->receivesInPocket()->get()->sortBy('date');
        $contractReceives =  $receives;
        $receives = $service->prepareReceives($receives); // merge receives with ready to fill receives
        $installments = $contract->installments;
        $detail = $service->getDetail($contract);

        $hasValidAdvancePayment = $contract->advancePaymentRel()->paid_at || $contract->advancePaymentRel()->due_at ? true : false;

        return view('admin.receives.create', compact('cards', 'companies', 'formAttributes', 'receives', 'contract', 'detail', 'installments', 'contractReceives', 'hasValidAdvancePayment'));
    }

    public function store(Request $request, Contract $contract)
    {
        try {
            $service = $this->service;
            $receives =  $request->receives;
            $receives = $service->removeUnused($receives);
            $service->sync($receives, $contract);
            (new InstallmentService())->updateInstallmentsByTotalReceives($contract, $contract->receivesInPocket(false)->get()->sum('amount'));
            $this->successAlert(null, 'پرداخت با موفقیت ثبت شد');
            return back();
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }
    }


    public function valid(Contract $contract)
    {
        $installments = $contract->installments;
        return !$installments->isEmpty();
    }
}
