<?php

namespace App\Services;

use App\Models\Card;


class CardService
{
    /**
     * Collection of attributes
     *
     * @param Customer|null $customer
     * @return array
     */
    public function formAttributes(?Card $card = null) : array
    {
        if ($card) {
            $action = route('cards.update', $card->id);
            $method = 'PUT';
            $form = 'update';
        }else{
            $action = route('cards.store');
            $method = 'POST';
            $form = 'store';
        }

        return compact('action', 'method', 'form');
    }


    public function storeOrUpdate(array $data, ?Card $card = null) : Card
    {
        $preparedData = [
            'name'=>$data['name'],
            'number'=>$data['number'],
            'amount'=>$data['amount'] ?? 0,
        ];

        if ($card) {
            $card->fill($preparedData);
            $card->save();
        }else{
            $card = Card::create($preparedData);
        }

        return $card ;
    }
}
