<?php

namespace App\Services;

use App\Models\Contract;

class ContractService
{
    /**
     * Collection of attributes
     *
     * @param Customer|null $customer
     * @return array
     */
    public function formAttributes(?Contract $contract = null) : array
    {
        if ($contract) {
            $action = route('contracts.update', $contract->id);
            $method = 'PUT';
            $form = 'update';
            $isUpdate = true;
        }else{
            $action = route('contracts.store');
            $method = 'POST';
            $form = 'store';
            $isUpdate = false;
        }

        return compact('action', 'method', 'form', 'isUpdate');
    }


    public function storeOrUpdate(array $data, ?Contract $contract = null) : Contract
    {
        dd($data);
        $preparedData = [
            'name'=>$data['name'],
            'number'=>$data['number'],
            'amount'=>$data['amount'] ?? 0,
        ];

        if ($contract) {
            $contract->fill($preparedData);
            $contract->save();
        }else{
            $contract = Contract::create($preparedData);
        }

        return $contract ;
    }
}
