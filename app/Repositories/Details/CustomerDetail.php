<?php

namespace App\Repositories\Details;

use App\Models\Contract;
use App\Models\Customer;
use App\Models\Installment;
use App\Services\ReceiveService;

class CustomerDetail extends Detail
{
    protected $data;
    protected $customer;
    protected $companies;
    protected $receives;
    protected $totalDebtor;
    protected $accumulative;

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

        // all receives from this customer
        $contractReceivesLists = $customer->contracts->where('archived', false)->map(function ($contract) {
            return $contract->receives;
        });
        $contractReceivesLists = $contractReceivesLists->collapse();

        // all installments from this customer
        $contractInstallmentsList = $customer->contracts->where('archived', false)->map(function ($contract) {
            return $contract->installments;
        });
        $contractInstallmentsList = $contractInstallmentsList->collapse();

        $accumulative = collect();
        $accumulative = $accumulative->merge($contractInstallmentsList);
        $accumulative = $accumulative->merge($contractReceivesLists);
        $accumulative = $accumulative->map(function ($item) {
            /**
             * Some receives are check and just have due_at some receives are deposit and
             * just have paid_at. checkout_at has merge value for sorting in customer single page
             */
            if ($item instanceof Installment) {
                $item->checkout_at = $item->due_at;
            } else {
                if ($item->type == 'deposit') {
                    $item->checkout_at = $item->paid_at;
                } else {
                    $item->checkout_at = $item->due_at;
                }
            }
            return $item;
        });
        $accumulative = $accumulative->sortBy('checkout_at');
        $this->accumulative = $accumulative;
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
            'accumulative'   => $this->accumulative,
            ...$mergeData
        ]);
    }
}
