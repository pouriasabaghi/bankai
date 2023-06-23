<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContractRequest;
use App\Models\Card;
use App\Models\Contract;
use App\Models\Service;
use App\Models\Type;
use App\Services\ContractService;
use App\Services\ReceiveService;
use App\Traits\Alert;
use App\Traits\Redirect;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    use Alert, Redirect;

    protected ContractService $service;

    public function __construct()
    {
        $this->service = new ContractService();
    }

    public function index()
    {
        $contracts = Contract::query()->latest()->paginate(50);
        return view('admin.contracts.index', compact('contracts'));
    }

    public function create()
    {
        $service = $this->service;
        $formAttributes = $service->formAttributes();
        $types = Type::query()->latest()->get();
        $services = Service::query()->latest()->get();
        $contractServices = null;
        $cards = Card::query()->get();
        return view('admin.contracts.create', compact('formAttributes', 'types', 'services', 'contractServices', 'cards'));
    }


    public function store(ContractRequest $request)
    {
        $ContractService = $this->service;
        $contract = $ContractService->storeOrUpdate($request->all());

        (new ReceiveService())->storeAdvancePayment($contract, $request->card_id, fix_number($request->advance_payment));

        $this->successAlert(null, 'قرارداد با موفقیت ثبت شد');

        return $this->redirect(route('installments.create', $contract->id));
    }

    public function edit(Contract $contract)
    {
        $ContractService = $this->service;
        $formAttributes = $ContractService->formAttributes($contract);
        $types = Type::query()->latest()->get();
        $services = Service::query()->latest()->get();
        $contractServices = $contract->services->pluck('id') ?? null;
        $cards = Card::query()->get();
        return view('admin.contracts.edit', compact('formAttributes', 'types', 'services', 'contractServices', 'contract','cards'));
    }


    public function update(ContractRequest $request, Contract $contract)
    {
        $service = $this->service;
        $contract = $service->storeOrUpdate($request->all(), $contract);

        (new ReceiveService())->storeAdvancePayment($contract, $request->card_id, fix_number($request->advance_payment), true);

        $this->successAlert(null, 'قرارداد با موفقیت ویرایش شد');

        //  return $this->redirect(route('contracts.index'));
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
