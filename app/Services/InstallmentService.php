<?php

namespace App\Services;

use App\Models\Contract;
use App\Models\Installment;
use Illuminate\Support\Collection;

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

    /**
     * calculate installments and return $count, $amount (amount of per installment)
     *
     * @param string|integer $totalPrice
     * @param string|integer $period
     * @param int            $step step of installments amount
     * @return array
     */
    public function calculateInstallments(string|int $totalPrice, string|int|null $period = 1, ?int $step = 10000) : array
    {

        $totalPrice = intval($totalPrice);
        $count = intval(fix_number($period)) == 0 ? 1 : intval(fix_number($period)) ;
        $amount = floor($totalPrice / $count); // every installment without any rest
        $amount =  $amount - (intval($amount) % $step); // step is 100 thousand
        $remainingAmount = $totalPrice - ($amount * ($count - 1));  // last installment amount;

        $installmentsAmount = array_fill(0, $count - 1, intval($amount)); // normal installment amount
        $installmentsAmount[] = intval($remainingAmount); // last installment
        return [$installmentsAmount, $count] ;
    }


    /**
     * Get collection of installments and return 50 installment depend on current count
     *
     * @param Collection $installments
     * @return Collection
     */
    public function prepareInstallments(Collection $installments) : Collection
    {
        $contractInstallments = $installments;
        $emptyInstallments = range($contractInstallments->count(), 60 - $contractInstallments->count());
        $installments = collect($contractInstallments)->merge($emptyInstallments);
        return $installments ;
    }
}
