<?php

namespace App\Repositories\Details;

use App\Models\Customer;
use App\Services\ReceiveService;

class CustomerDetail extends Detail
{
    protected $data;
    protected $customer;
    protected $companies;
    protected $receives;
    protected $totalDebtor;
    protected $receivesForAllContracts ;

    protected ReceiveService $receiveService;
    public function getDetail($id)
    {
        $customer        = Customer::findOrFail($id);
        $this->customer  = $customer;
        $this->companies = $customer->companies->pluck('name')->implode('، ');

        $this->receiveService = new ReceiveService();
        $this->totalDebtor    = $customer->contracts()->get()->sum(function ($contract) {
            return $this->receiveService->getDetail($contract)['rawDebtor'];
        });

        $this->data     = $customer->contracts;
        $this->receives = $customer->receives()->take(5)->get();

        $receivesLists = $customer->contracts->where('archived', false)->map(function($contract){
            return $contract->receives;
        });
        $receivesLists = $receivesLists->collapse()->sortBy(function($receive){
            return $receive->checkout_at;
        });

        $this->receivesForAllContracts = $receivesLists ;
    }

    public function renderView(array $mergeData = [])
    {
        return parent::renderView([
            'contracts'      => $this->data,
            'customer'       => $this->customer,
            'companies'      => $this->companies,
            'receives'       => $this->receives,
            'totalDebtor'    => $this->totalDebtor,
            'receiveService' => $this->receiveService,
            'receivesForAllContracts'=>$this->receivesForAllContracts,
            ...$mergeData
        ]);
    }
}
