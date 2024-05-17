<?php

namespace App\Services;

use App\Models\Card;
use Illuminate\Support\Collection;
use \App\Models\Payment;

class PaymentService
{

    /**
     * Collection of attributes
     *
     * @param \App\Models\Payment|null $payment
     * @return array
     */
    public function formAttributes(?Payment $payment = null): array
    {
        if ($payment) {
            $action = route('payments.update', $payment->id);
            $method = 'PUT';
            $form   = 'update';
        } else {
            $action = route('payments.store');
            $method = 'POST';
            $form   = 'store';
        }

        return compact('action', 'method', 'form');
    }


    public function storeOrUpdate(\Illuminate\Http\Request $request, ?Payment $payment = null): Payment
    {
        $request->validate([
            'from'   => 'required',
            'to'     => 'required',
            'amount' => 'required',
            'cost'   => 'required',
        ]);

        // remove separate digit char from amount
        $amount = fix_number($request->amount);

        // get card from and card to model
        $fromCardModel = Card::findOrFail($request->from);
        $toCardModel   = Card::firstWhere('number', $request->to);

        $to = $request->to;

        // check for balance
        if ($fromCardModel->amount < $amount)
            throw new \Exception('موجودی حساب مبدا کافی نمی‌باشد.', 1);

        if ($fromCardModel->number === $toCardModel?->number)
            throw new \Exception('حساب مبدا و مقصد یکسان است.', 1);

        $to = $request->to;
        // check if card exist in card list
        if ($request->has('add_to_cards') && !$toCardModel) {
            // create new card;
            $to = Card::create([
                'name'   => '*ثبت نشده*',
                'number' => $request->to,
                'amount' => $amount,
            ])->number;
        } else if ($toCardModel) {
            // update card amount
            $to = $toCardModel->number;
            $toCardModel->increment('amount', $amount);
        }


        // کسر مبلغ از حساب مبدا
        $fromCardModel->refresh()->decrement('amount', $amount);

        if ($payment) {
            // previous card from
            $previousFromCard = $payment->fromCard;

            // previous card to .
            $previousToCard = Card::firstWhere('number', $payment->to);

            // کسر مبلغ از حساب مقصد قدیم
            $previousToCard?->decrement('amount', $payment->amount);

            // اضافه کردن مبلغ به حساب مبدا قدیم
            $previousFromCard->increment('amount', $payment->amount);



            $payment->fill([
                'from'    => $request->from,
                'to'      => $to,
                'amount'  => $request->amount,
                'cost_id' => $request->cost,
                'desc'    => $request->desc,
            ]);

            $payment->save();
        } else {

            $payment = Payment::create([
                'from'    => $request->from,
                'to'      => $to,
                'amount'  => $request->amount,
                'cost_id' => $request->cost,
                'desc'    => $request->desc,
            ]);

        }

        return $payment;
    }

}
