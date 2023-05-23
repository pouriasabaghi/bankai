<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContractRequest;
use App\Models\Contract;
use App\Models\Service;
use App\Models\Type;
use App\Services\ContractService;
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
        $contractServices = null ;
        return view('admin.contracts.create', compact('formAttributes', 'types', 'services', 'contractServices'));
    }


    public function store(ContractRequest $request)
    {
        $service = $this->service;
        $service->storeOrUpdate($request->all());
        $this->successAlert(null, 'قرارداد با موفقیت ثبت شد');

        return $this->redirect(route('contracts.index'));
    }

    public function edit(Contract $contract)
    {
        $service = $this->service;
        $formAttributes = $service->formAttributes($contract);
        $types = Type::query()->latest()->get();
        $services = Service::query()->latest()->get();
        $contractServices = $contract->services->pluck('id') ?? null;
        return view('admin.contracts.edit', compact('formAttributes', 'types', 'services','contractServices', 'contract'));
    }


    public function update(Request $request, Contract $contract)
    {
        $service = $this->service;
        $contract = $service->storeOrUpdate($request->all(), $contract);
        $this->successAlert(null, 'قرارداد با موفقیت ویرایش شد');

        return $this->redirect(route('contracts.index'));
    }

    public function destroy($id)
    {
        $contract = Contract::query()->findOrFail($id);
        $contract->delete();
        $this->successAlert(null, 'قرارداد با موفقیت حذف شد');
        return $this->redirect(route('contracts.index'));
    }
}
