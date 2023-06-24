<?php

namespace App\Services;

use App\Models\Contract;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Collection;


class InstallmentService
{

    // summarize of installments;
    private $sum;

    /**
     * Collection of attributes
     *
     * @param Contract $contract
     * @return array
     */
    public function formAttributes(Contract $contract): array
    {
        $action = route('installments.store', $contract->id);
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
     * calculate installments and return $count, $amount (amount of per installment)
     *
     * @param string|integer $totalPrice
     * @param string|integer $period
     * @param int            $step step of installments amount
     * @return array
     */
    public function calculateInstallments(string|int $totalPrice, string|int|null $period = 1, ?int $step = 10000, ?int $count = null): array
    {

        $totalPrice = intval($totalPrice);

        if (!$count) {
            $count = intval(fix_number($period)) == 0 ? 1 : intval(fix_number($period));
        }

        $amount = floor($totalPrice / $count); // every installment without any rest
        $amount =  $amount - (intval($amount) % $step); // step is 100 thousand
        $remainingAmount = $totalPrice - ($amount * ($count - 1));  // last installment amount;

        $installmentsAmount = array_fill(0, $count - 1, intval($amount)); // normal installment amount
        $installmentsAmount[] = intval($remainingAmount); // last installment
        return [$installmentsAmount, $count];
    }


    /**
     * Get collection of installments and return 50 installment depend on current count
     *
     * @param Collection $installments
     * @return Collection
     */
    public function prepareInstallments(Collection $installments): Collection
    {
        $contractInstallments = $installments;
        $emptyInstallments = range($contractInstallments->count(), 24 - $contractInstallments->count());
        $installments = collect($contractInstallments)->merge($emptyInstallments);

        return $installments;
    }


    /**
     * remove unused (where amount and due_at is empty) installments
     *
     * @param array $installments
     * @return array
     */
    public function removeUnusedInstallments(array $installments): array
    {
        $installments = array_filter($installments, function ($installment) {
            return $installment['amount'] != null;
        });

        return $installments;
    }


    /**
     * Summarize installments
     *
     * @param array|Collection $installments
     * @return InstallmentService
     */
    public function sumInstallments(array|Collection $installments): InstallmentService
    {
        $installments = $this->removeUnusedInstallments($installments);

        if (!$installments instanceof Collection) {
            $installments = collect($installments);
        }
        $sum = $installments->sum(function ($installment) {
            if (!empty($installment['amount']) && empty($installment['due_at'])) {
                throw new Exception('تاریخ اقساط نامعبتر. دقت کنید تاریخ نمی‌تواند خالی باشد.');
            }

            if (!empty($installment['amount']) && $installment['type'] == 'planned') {
                return fix_number($installment['amount']);
            }
        });
        $this->sum = $sum;
        return $this;
    }

    public function getSum()
    {
        return $this->sum;
    }


    public function validate(int $totalPrice) //: bool|Exception
    {
        $totalPrice = fix_number($totalPrice);
        if ($this->sum == $totalPrice) {
            return true;
        } else {
            throw new Exception('مانده اقساط نامعتبر است.', 1);
        }
    }

    public function updateInstallmentsByTotalReceives(Contract $contract, int|string $totalReceivesAmount)
    {
        // ابتدا کل دریافتی ها را محاسبه میکنیم سپس کل اقساط را دریافت میکنیم در هر دور حلقه
        // مبلغ دریافت شده ها را از یک قسط کم میکنیم اگر باقی مانده ای باشد
        // قسط پرداخت شده و مقدار باقی مانده نیز مجدد محساب می شود
        $totalReceivesAmount = intval(fix_number($totalReceivesAmount));
        $installments = $contract->installmentsCollectible()->get();
        $remainingAmount =  $totalReceivesAmount;
        foreach ($installments as $installment) {
            // temporary keep remain
            $tempRemainAmount = $remainingAmount -  $installment->amount;
            if ($tempRemainAmount >= 0) {
                // temp can pay installment so update remain amount
                $remainingAmount = $remainingAmount -  $installment->amount;
                $installment->update(['status' => 'paid']);
            } else {
                $installment->update(['status' => 'billed']);
            }
        }
    }

    /**
     * if contract canceled all installment after canceled_at are not collectible
     *
     * @param Contract $contract
     * @param Carbon $canceledAt
     * @return void
     */
    public function updateCollectibleInstallments(Contract $contract, ?Carbon $canceledAt = null): void
    {
        $installments =  $contract->installments;
        foreach ($installments as $installment) {
            $installment->update([
                'collectible' => true,
            ]);
        }

        if ($canceledAt) {
            $installmentsAfterCanceledAt = $contract->installments()->where('due_at', '>', $canceledAt)->get();
            foreach ($installmentsAfterCanceledAt as $installment) {
                $installment->update([
                    'collectible' => $installment->type == 'canceled' ? true : false,
                ]);
            }
        }
    }
}
