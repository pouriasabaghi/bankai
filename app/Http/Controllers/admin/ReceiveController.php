<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\Company;
use App\Models\Contract;
use App\Services\ReceiveService;
use Illuminate\Http\Request;

class ReceiveController extends Controller
{
    private ReceiveService $service ;
    public function __construct()
    {
        $this->service = new ReceiveService(); ;
    }
    public function create(Contract $contract)
    {
        $service = $this->service ;
        $cards = Card::query()->latest()->get();
        $companies =  $contract->customer->companies;
        $formAttributes = $service->formAttributes($contract);
        $receives = $contract->receives ;
        $receives = $service->prepareReceives($receives);
        return view('admin.receives.create', compact('cards', 'companies', 'formAttributes', 'receives', 'contract'));
    }

    public function store(Request $request)
    {
       dd($request);
    }
}
