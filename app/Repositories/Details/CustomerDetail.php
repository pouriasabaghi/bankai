<?php

namespace App\Repositories\Details;

use App\Models\Customer;

class CustomerDetail extends Detail
{
    protected $data;
    protected $customer;
    protected $companies ;
    protected $receives ;
    protected $totalDebtor;
    public function getDetail($id)
    {
        $customer = Customer::findOrFail($id);
        $this->customer = $customer;
        $this->companies = $customer->companies->pluck('name')->implode('، ') ;

        $this->totalDebtor = $customer->contracts()->get()->sum(function($contract){
            return $contract->debtorInstallments()->sum('amount');
        });

        $this->data = $customer->contracts;
        $this->receives = $customer->receives()->take(5)->get();
    }

    public function renderView(array $mergeData = [])
    {
        return parent::renderView(['contracts' => $this->data,
        'customer' => $this->customer,
        'companies'=>$this->companies,
        'receives'=>$this->receives,
        'totalDebtor'=>$this->totalDebtor,
        ...$mergeData]);
    }
}
