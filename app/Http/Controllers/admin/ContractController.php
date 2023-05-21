<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Contract;
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
        return view('admin.contracts.create', compact('formAttributes'));
    }
}
