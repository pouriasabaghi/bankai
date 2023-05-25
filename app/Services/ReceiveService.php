<?php

namespace App\Services;

use App\Models\Contract;
use Exception;
use Illuminate\Support\Collection;

class ReceiveService
{

    /**
     * Collection of attributes
     *
     * @param Contract $contract
     * @return array
     */
    public function formAttributes(Contract $contract): array
    {
        $action = route('contracts.store', $contract->id);
        $method = 'POST';
        $isUpdate = false;

        return compact('action', 'method', 'isUpdate');
    }


    public function sync(array $data, Contract $contract): Collection
    {
        $preparedData = $data;

        $contract->installments()->delete();
        $installments = $contract->installments()->createMany($preparedData);

        return $installments;
    }


        /**
     * Get collection of receives and return 50 installment depend on current count
     *
     * @param Collection $receives
     * @return Collection
     */
    public function prepareReceives(Collection $receives): Collection
    {
        $contractReceives = $receives;
        $emptyReceives = range($contractReceives->count(), 60 - $contractReceives->count());
        $receives = collect($contractReceives)->merge($emptyReceives);

        return $receives;
    }

}
