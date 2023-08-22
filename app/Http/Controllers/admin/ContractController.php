<?php

namespace App\Http\Controllers\admin;

use App\Enums\ContractStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContractRequest;
use App\Models\Card;
use App\Models\Contract;
use App\Models\Service;
use App\Models\Type;
use App\Services\ContractService;
use App\Services\InstallmentService;
use App\Services\ReceiveService;
use App\Traits\Alert;
use App\Traits\Redirect;

class ContractController extends Controller
{
    use Alert, Redirect;


    public function index()
    {
        $contracts = Contract::query()->latest()->paginate(50);
        return view('admin.contracts.index', compact('contracts'));
    }

    public function create(ContractService $service)
    {
        $formAttributes = $service->formAttributes();
        $types = Type::query()->latest()->get();
        $services = Service::query()->latest()->get();
        $contractServices = null;
        $cards = Card::query()->get();
        return view('admin.contracts.create', compact('formAttributes', 'types', 'services', 'contractServices', 'cards'));
    }


    public function store(ContractRequest $request, ContractService $service)
    {
        $ContractService = $service;

        $contract = $ContractService->storeOrUpdate($request->all());


        if ($request->advance_payment) {
            (new ReceiveService())->storeAdvancePayment($contract, $request->card_id, fix_number($request->advance_payment));
        }

        $this->successAlert(null, 'قرارداد با موفقیت ثبت شد');

        return $this->redirect(route('installments.create', $contract->id));
    }

    public function edit(Contract $contract, ContractService $service)
    {
        $ContractService = $service;
        $formAttributes = $ContractService->formAttributes($contract);
        $types = Type::query()->latest()->get();
        $services = Service::query()->latest()->get();
        $contractServices = $contract->services->pluck('id') ?? null;
        $cards = Card::query()->get();
        $advancePaymentReceive = $contract->advancePaymentRel();
        return view('admin.contracts.edit', compact('formAttributes', 'types', 'services', 'contractServices', 'contract', 'cards', 'advancePaymentReceive'));
    }


    public function update(
        ContractRequest $request,
        Contract $contract,
        ContractService $contractService,
        ReceiveService $receiveService,
        InstallmentService $installmentService
    ) {
        $contract = $contractService->storeOrUpdate($request->all(), $contract);

        // store advance payment as receive

        if ($request->advance_payment) {
            $receiveService->storeAdvancePayment($contract, $request->card_id, fix_number($request->advance_payment), true);
        }

        // update contract status
        $status = $request->canceled_at ? ContractStatusEnum::Canceled : ContractStatusEnum::Progress;
        $contractService->updateContractStatus($contract, $status);

        // handle installment collectible when contract canceled
        $installmentService->updateCollectibleInstallments($contract, !empty($request->canceled_at));

        $this->successAlert(null, 'قرارداد با موفقیت ویرایش شد');

        return $this->redirect(route('installments.create', $contract->id));
    }

    public function destroy($id)
    {
        $contract = Contract::query()->findOrFail($id);
        $contract->delete();
        $this->successAlert(null, 'قرارداد با موفقیت حذف شد');
        return $this->redirect(route('contracts.index'));
    }
}
