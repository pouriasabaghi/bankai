<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\Service;
use App\Models\Type;
use App\Services\ContractService;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    protected ContractService $service ;

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
        return view('admin.contracts.create', compact('formAttributes', 'types', 'services'));
    }


    public function store(Request $request)
    {
        dd($request->all());
    }

    public function edit(Contract $contract)
    {

    }


    public function update(Request $request, Contract $contract)
    {

    }

    public function destroy($id)
    {

    }
}
