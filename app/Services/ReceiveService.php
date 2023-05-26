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
        $preparedData =  $this->filterByType($data) ;
        $contract->receives()->delete();
        $receives = $contract->receives()->createMany($preparedData);

        // update cards amount ;
        $cardService = new CardService();
        $cards = $cardService->sumCardsWithKey() ;
        foreach($cards as $card){
            Card::query()->whereId($card['card_id'])->update([
                'amount'=> $card['sum'],
            ]);
        }
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
            return $item['amount'] != null ;
        });
        return $arr;
    }


    /**
     * Clear not related inputs from every receives depend on their type
     *
     * @param array|Collection $arr
     * @return Collection
     */
    public function filterByType(array|Collection $arr) : Collection
    {
        if (! $arr instanceof Collection) {
            $arr = collect($arr) ;

        }
        $arr = $arr->map(function($item){
            if ($item['type'] == 'deposit') {
                if (empty($item['paid_at'])) {
                    throw new Exception('تاریخ پرداخت نمی‌تواند خالی باشد.');
                }
                return [
                    'paid_at'=> $item['paid_at'],
                    'origin'=> $item['origin'],
                    'type'=> $item['type'],
                    'amount'=> $item['amount'],
                    'customer_id'=> $item['customer_id'],
                    'company_id'=> $item['company_id'],
                    'contract_id'=> $item['contract_id'],
                    'card_id'=> $item['card_id'],
                ];
            }elseif($item['type'] == 'check'){
                if (empty($item['due_at']) || empty($item['received_at'])) {
                    throw new Exception('تاریخ دریافت و سررسید نمی‌تواند خالی باشد.');
                }
                return [
                    'received_at'=>$item['received_at'],
                    'desc'=>$item['desc'],
                    'bank_name'=>$item['bank_name'],
                    'branch_code'=>$item['branch_code'],
                    'branch_name'=>$item['branch_name'],
                    'due_at'=>$item['due_at'],
                    'serial_number'=>$item['serial_number'],
                    'type'=> $item['type'],
                    'amount'=> $item['amount'],
                    'customer_id'=> $item['customer_id'],
                    'company_id'=> $item['company_id'],
                    'contract_id'=> $item['contract_id'],
                    'card_id'=> $item['card_id'],
                ];
            }

        });

        return $arr;
    }

}
