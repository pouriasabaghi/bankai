<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\Cost;
use App\Models\Payment;
use App\Services\PaymentService;
use App\Traits\Alert;
use App\Traits\Redirect;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    use Alert, Redirect;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = Payment::query()->with(['fromCard', 'cost'])->latest()->paginate(50);
        return view('admin.payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(PaymentService $service)
    {
        $formAttributes = $service->formAttributes();
        $cards          = Card::all();
        $costs          = Cost::all();
        return view('admin.payments.create', compact('formAttributes', 'cards', 'costs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, PaymentService $service)
    {
        try {
            $service->storeOrUpdate($request);

            $this->successAlert(null, 'پرداختی با موفقیت ثبت شد');
            return $this->redirect(route('payments.index'));
        } catch (\Exception $exception) {
            dd($exception->getLine(), $exception->getMessage());
            return back()->withErrors($exception->getMessage());
        }


    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment, PaymentService $service)
    {
        $formAttributes = $service->formAttributes($payment);
        $cards          = Card::all();
        $costs          = Cost::all();
        return view('admin.payments.edit', compact('formAttributes', 'cards', 'costs', 'payment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment, PaymentService $service)
    {
        try {
            $service->storeOrUpdate($request, $payment);

            $this->successAlert(null, 'پرداختی با موفقیت ویرایش شد');
            return $this->redirect(route('payments.index'));
        } catch (\Exception $exception) {
            return back()->withErrors($exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $payment = Payment::findOrFail($id);

        // return amount to card from.
        $payment->fromCard()->increment('amount', $payment->amount);

        // decrement amount form to card.
        $cardToModel = Card::firstWhere('number', $payment->to);
        if ($cardToModel)
            $cardToModel->decrement('amount', $payment->amount);


        $payment->delete();
        $this->successAlert(null, 'پرداختی با موفقیت حذف شد');
        return $this->redirect(route('payments.index'));
    }
}
