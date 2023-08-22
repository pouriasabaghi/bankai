<?php

namespace App\Services;

use App\Enums\ContractStatusEnum;
use App\Models\Contract;

class ContractService
{


    /**
     * Collection of attributes
     *
     * @param Customer|null $customer
     * @return array
     */
    public function formAttributes(?Contract $contract = null): array
    {
        if ($contract) {
            $action = route('contracts.update', $contract->id);
            $method = 'PUT';
            $form = 'update';
            $isUpdate = true;
        } else {
            $action = route('contracts.store');
            $method = 'POST';
            $form = 'store';
            $isUpdate = false;
        }

        return compact('action', 'method', 'form', 'isUpdate');
    }


    public function storeOrUpdate(array $data, ?Contract $contract = null): Contract
    {
        $payable = !empty($data['canceled_at']) ? $contract->canceledInstallment()->amount  : $data['total_price'];

        $preparedData = [
            'customer_id' => $data['customer_id'],
            'company_id' => $data['company_id'],
            'name' => $data['name'],
            'desc' => $data['desc'],
            'total_price' => $data['total_price'],
            'payable' => $payable,
            'advance_payment' => $data['advance_payment'],
            'installments_total_price' => fix_number($data['total_price']) -  fix_number($data['advance_payment']),
            'type' => $data['type'],
            'contract_number' => $data['contract_number'],
            'period' => $data['period'],
            'signed_at' => $data['signed_at'],
            'started_at' => $data['started_at'],
            'canceled_at' => $data['canceled_at'] ?? null,
            'expired_at' => $data['expired_at'] ?? null,
            'services' => $data['services'] ?? null,
        ];

        if ($contract) {
            $contract->fill($preparedData);
            $contract->save();
            $contract->services()->sync($preparedData['services']);
        } else {
            $contract = Contract::create($preparedData);
            if ($preparedData['services']) {
                $contract->services()->sync($preparedData['services']);
            }
        }
        return $contract;
    }

    public function updateContractStatus(Contract $contract, ContractStatusEnum $status)
    {
        $contract->update([
            'contract_status' => $status->value,
        ]);
    }

    public function getContractYearlyBalancePercent(Contract $contract){
        $currentYear = $contract->getCurrentYearContract()->count();
        $lastYear = $contract->getLastYearContract()->count();
        $balance =round((($currentYear - $lastYear) / $lastYear) * 100 , 2);

        return [
            'percent'=> $balance ,
            'improvement' => $balance  > 0
        ] ;
    }
}
