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


        $preparedData = [
            'customer_id'=>$data['customer_id'],
            'company_id'=>$data['company_id'],
            'name'=>$data['name'],
            'desc'=>$data['desc'],
            'total_price'=>$data['total_price'],
            'type'=>$data['type'],
            'contract_number'=>$data['contract_number'],
            'period'=>$data['period'],
            'signed_at'=>!empty($data['signed_at']) ? jdate()->fromFormat('Y/m/d', $data['signed_at'] )->toCarbon() : null,
            'services'=>$data['services'] ?? null,
        ];

        if ($contract) {
            $contract->fill($preparedData);
            $contract->save();
        }else{
            $contract = Contract::create($preparedData);
            if ($preparedData['services']) {
                $contract->services()->sync($preparedData['services']);
            }
        }
        return $contract ;
    }
}
