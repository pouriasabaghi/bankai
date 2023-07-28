<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\Company;
use App\Models\Contract;
use App\Services\InstallmentService;
use App\Services\ReceiveService;
use App\Traits\Alert;
use Exception;
use Illuminate\Http\Request;

class ReceiveController extends Controller
{
    use Alert;
    private ReceiveService $service;
    public function __construct()
    {
        $this->service = new ReceiveService();;
    }
    public function create(Contract $contract)
    {

        if (!$this->valid($contract)) {
            return redirect(route('installments.create', $contract->id))->withErrors('ابتدا اقساط را تعریف و ذخیره کنید');
        }
        $service = $this->service;
        $cards = Card::query()->latest()->get();
        $companies =  $contract->customer->companies;
        $formAttributes = $service->formAttributes($contract);
        $receives = $contract->receives->sortBy('date');
        $contractReceives =  $contract->receivesInPocket()->get();
        $receives = $service->prepareReceives($receives); // merge receives with ready to fill receives
        $installments = $contract->installments;
        $detail = $service->getDetail($contract);


        $this->messages($contract);

        return view('admin.receives.create', compact('cards', 'companies', 'formAttributes', 'receives', 'contract', 'detail', 'installments', 'contractReceives'));
    }

    public function store(Request $request, Contract $contract)
    {
        try {
            $service = $this->service;
            $receives =  $request->receives;
            $receives = $service->removeUnused($receives);
            $service->sync($receives, $contract);
            (new InstallmentService())->updateInstallmentsByTotalReceives($contract, $contract->receivesInPocket(false)->get()->sum('amount'));
            $this->successAlert(null, 'پرداخت با موفقیت ثبت شد');
            return back();
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }
    }


    public function valid(Contract $contract)
    {
        $installments = $contract->installments;
        return !$installments->isEmpty();
    }


    public function messages(Contract $contract)
    {
        $messages = [];
        if (!empty($contract->advance_payment) && empty($contract->advancePaymentRel()->paid_at) && empty($contract->advancePaymentRel()->due_at)) {
            $messages[] = [
                'type' => 'warning',
                'text' => 'لطفا ابتدا جزئیات دریافت پیش قرارداد را کامل کنید.',
            ];
        }

        if ($contract->canceledInstallment() && !$contract->canceled_at) {
            $messages[] = [
                'type' => 'danger',
                'text' => 'در صورت کنسل شدن قرار داد حتما تاریخ کنسلی را از بخش ویرایش قرارداد ثبت کنید.',
            ];
        }

        if (!$contract->canceledInstallment() && $contract->canceled_at) {
            $messages[] = [
                'type' => 'warning',
                'text' => 'در صورت کنسل شدن قرارداد مبلغ کنسلی را وارد کنید.',
            ];
        }

        if (count($messages)) {
            session()->flash('messages', $messages);
        }
    }
}
