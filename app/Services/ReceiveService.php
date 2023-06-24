<?php

namespace App\Services;

use App\Models\Card;
use App\Models\Contract;
use App\Models\Receive;
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
        $action = route('receives.store', $contract->id);
        $method = 'POST';
        $isUpdate = false;

        return compact('action', 'method', 'isUpdate');
    }


    /**
     * sync (delete and create)  receives ;
     *
     * @param array $data
     * @param Contract $contract

     * @return Collection
     */
    public function sync(array $data, Contract $contract): Collection
    {
        $preparedData =  $this->filterByType($data);
        $contract->receives()->delete();
        $receives = $contract->receives()->createMany($preparedData);

        // update cards amount ;
        $cardService = new CardService();
        $cardService->sumCardsWithKey()->updateCardsAmount();

        return $receives;
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
        $emptyReceives = range($contractReceives->count(), 30 - $contractReceives->count());
        $receives = collect($contractReceives)->merge($emptyReceives);

        return $receives;
    }


    /**
     * remove unused (where amount or (due_at | paid_at ) is empty) receives
     *
     * @param array $receives
     * @return array
     */
    public function removeUnused(array $arr): array
    {
        $arr = array_filter($arr, function ($item) {
            return $item['amount'] != null;
        });
        return $arr;
    }


    /**
     * Clear not related inputs from every receives depend on their type
     *
     * @param array|Collection $arr
     * @return Collection
     */
    public function filterByType(array|Collection $arr): Collection
    {
        if (!$arr instanceof Collection) {
            $arr = collect($arr);
        }
        $arr = $arr->map(function ($item) {
            if ($item['type'] == 'deposit') {
                if (empty($item['paid_at'])) {
                    throw new Exception('تاریخ پرداخت نمی‌تواند خالی باشد.');
                }
                return [
                    'paid_at' => $item['paid_at'],
                    'origin' => $item['origin'],
                    'type' => $item['type'],
                    'amount' => $item['amount'],
                    'customer_id' => $item['customer_id'],
                    'company_id' => $item['company_id'],
                    'contract_id' => $item['contract_id'],
                    'card_id' => $item['card_id'],
                    'advance_payment' => $item['advance_payment'] ?? false,
                ];
            } elseif ($item['type'] == 'check') {
                if (empty($item['due_at']) || empty($item['received_at'])) {
                    throw new Exception('تاریخ دریافت و سررسید نمی‌تواند خالی باشد.');
                }
                return [
                    'received_at' => $item['received_at'],
                    'desc' => $item['desc'],
                    'bank_name' => $item['bank_name'],
                    'branch_code' => $item['branch_code'],
                    'branch_name' => $item['branch_name'],
                    'due_at' => $item['due_at'],
                    'serial_number' => $item['serial_number'],
                    'type' => $item['type'],
                    'amount' => $item['amount'],
                    'customer_id' => $item['customer_id'],
                    'company_id' => $item['company_id'],
                    'contract_id' => $item['contract_id'],
                    'card_id' => $item['card_id'],
                    'passed' => !empty($item['passed']) ? true :  false,
                    'advance_payment' => $item['advance_payment'] ?? false,
                ];
            }
        });

        return $arr;
    }


    /**
     * detail of installment like debtor, creditor, etc.
     *
     * @param Contract $contract
     * @return array
     */
    public function getDetail(Contract $contract): array
    {
        $debtor = $contract->installmentsCollectible()->where(function ($query) {
            $query->where('due_at', '<=', today())
                ->where('status', 'billed');
        })
            ->orWhere(function ($query) {
                $query->where('type','canceled')
                    ->where('status', 'billed');
            })->get()->sum('amount');

        // this amount use for paying bills (updating status) ;
        $usedAmount = $contract->installments()->where('status', 'paid')->get()->sum('amount');

        $paidAmount = $contract->receivesInPocket(false)->get()->sum('amount');

        $creditor = ($paidAmount - $usedAmount) > 0  ? $paidAmount - $usedAmount : 0;
        $debtorTillNow = $debtor - $creditor > 0 ? $debtor - $creditor : 0;

        return [
            'debtor' => number_format($debtorTillNow),
            'creditor' => number_format($creditor),
            'creditor_title' => $creditor && $debtor  == 0 ? 'بستانکار' : 'علی‌الحساب'
        ];
    }


    /**
     * Store advance payment as receive
     *
     * @param Contract $contract
     * @param int $cardId
     * @param int|string $amount
     * @return Receive
     */
    public function storeAdvancePayment(Contract $contract, int $cardId, int|string $amount, $update = false): Receive
    {
        $preparedData = [
            'contract_id' => $contract->id,
            'amount' => $amount,
            'card_id' => $cardId,
            'customer_id' => $contract->customer_id,
            'company_id' => $contract->company_id,
            'advance_payment' => true,
        ];

        if (!$update) {
            $receive = Receive::create($preparedData);
        } else {
            // Make instance from receive for update
            $receive = new Receive();
            $receive =  $receive->where([
                'contract_id' => $contract->id,
                'advance_payment' => true,
            ])->first();

            // there is no advance payment it's first time
            if (!$receive) {
                $receive = Receive::create($preparedData);
            } else {
                $receive->fill($preparedData);
                $receive->save();
            }
        }

        // update cards amount ;
        $cardService = new CardService();
        $cardService->sumCardsWithKey()->updateCardsAmount();

        return $receive;
    }
}
