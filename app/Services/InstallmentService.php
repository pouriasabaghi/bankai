<?php

namespace App\Services;

use App\Models\Contract;
use App\Models\Installment;


class InstallmentService
{

    /**
     * Collection of attributes
     *
     * @param Installment|null $installment
     * @return array
     */
    public function formAttributes(Contract $contract): array
    {
        $action = route('installments.store', $contract->id);
        $method = 'POST';
        $isUpdate = false;

        return compact('action', 'method', 'isUpdate');
    }


    public function storeOrUpdate(array $data, ?Installment $installment = null): Installment
    {
        dd($data);
        $preparedData = [
            'name' => $data['name'],
            'mobile' => $data['mobile'],
            'phone' => $data['phone'],
            'desc' => $data['desc'],
        ];
        if ($installment) {
            $installment->fill($preparedData);
            $installment->save();
        } else {
            $installment = Installment::create($preparedData);
        }

        return $installment;
    }
}
