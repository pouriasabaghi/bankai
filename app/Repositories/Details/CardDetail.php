<?php

namespace App\Repositories\Details;

use App\Models\Card;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;


class CardDetail extends Detail
{
    protected $data;
    protected $cardName;
    public function getDetail($id)
    {
        $card = Card::query()->findOrFail($id);

        $this->cardName = $card->name;

        $receives = $card->receives;
        $payments = $card->payments;

        $transactions = $receives->merge($payments);
        $sortedTransactions = $transactions->sortBy([
            'due_at'=>'asc',
            'paid_at'=>'asc',
        ]);

      //  dd($transactions->sortBy('updated_at'));
     //  dd($sortedTransactions);

        // Paginate
        $currentPage      = LengthAwarePaginator::resolveCurrentPage();
        $perPage          = 100;
        $currentPageItems = $sortedTransactions->slice(($currentPage - 1) * $perPage, $perPage)?->map(function ($transaction) {
            $isReceive = $transaction instanceof \App\Models\Receive;
            return [
                'id'        => $transaction->id,
                'contract'  => $isReceive ? $transaction->contract->name : $transaction->cost->name,
                'amount'    => $transaction->amount_str,
                'date'      => $transaction->date,
                'from'      => $isReceive ? $transaction->contract->customer->name : $transaction->fromCard->name,
                'to'        => $isReceive ? $transaction->card->name : $transaction->toName(),
                'type'      => $isReceive ? $transaction->type_str : 'واریز',
                'desc'      => $isReceive ? ($transaction->desc ?: $transaction->origin) : $transaction->desc,
                'isReceive' => $isReceive,
            ];
        });

        // dd($currentPageItems);
        $paginatedTransactions = new LengthAwarePaginator(
            $currentPageItems,
            $sortedTransactions->count(),
            $perPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );

        $this->data = $paginatedTransactions;
    }


    public function renderView(array $mergeData = [])
    {
        return parent::renderView(['data' => $this->data, 'cardName' => $this->cardName, ...$mergeData]);
    }
}
