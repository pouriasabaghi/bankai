<?php

namespace App\Http\Controllers\admin;

use App\Enums\ContractStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\Installment;
use App\Services\ContractService;
use App\Services\InstallmentService;
use App\Services\ReceiveService;
use App\Traits\Alert;
use App\Traits\Redirect;
use Exception;
use Illuminate\Http\Request;


class InstallmentController extends Controller
{
    use Alert, Redirect;
    protected InstallmentService $service;
    public function __construct()
    {
        $this->service = new InstallmentService();
    }
    public function create(Contract $contract)
    {
   //     dd(Installment::query()->get());
        $service = $this->service;
        $formAttributes = $service->formAttributes($contract);

        $installments = $service->prepareInstallments($contract->installments()->where('type', 'planned')->get());

        // canceled installment
        $canceled =  $contract->canceledInstallment();

        // contract status
        $contractStatus = $contract->contract_status == 'canceled' || !empty($canceled->amount) ? true : false;

        // installments start
        $start = request()->start ?? $contract->started_at;

        // it's update form/page;  contract didn't need auto installment calculate ;
        if (!$contract->installments->isEmpty() && !request()->has('start')) {
            $installmentsCount = -1;
            $installmentsAmount = [];
        } else {
            $installments = $service->prepareInstallments(collect());
            list($installmentsAmount, $installmentsCount) = $service->calculateInstallments($contract->installments_total_price, $contract->period, request()['step'] ?? 1000, request()['count'] ?? null);
        }



        return view('admin.installments.create', compact('contract', 'installments', 'formAttributes', 'installmentsCount', 'installmentsAmount', 'start', 'canceled', 'contractStatus'));
    }

    public function store(Request $request, Contract $contract)
    {
        try {


            $service = $this->service;
            $installments = $request->installment;

            // Add canceled to installments array.
            $canceled = $request->canceled;

            // Remove canceled installment from installments list if contract_status is not canceled
            if ($request->contract_status) {
                array_push($installments, [
                    "amount" => $canceled['amount'],
                    "due_at" => $canceled['due_at'],
                    "desc" => $canceled['desc'],
                    "type" => $canceled['type'],
                    "status" => $canceled['status'] ?? 'billed',
                ]);
            }

            $installments = $service->removeUnusedInstallments($installments);
            $service->sumInstallments($installments)->validate($contract->installments_total_price);
            $service->sync($installments, $contract);

            // handle installment collectible when contract canceled
            $canceledAt = $contract->canceled_at ? jdate()->fromFormat('Y/m/d', $contract->canceled_at)->toCarbon() : null;
            $service->updateCollectibleInstallments($contract, $canceledAt);
            $service->updateInstallmentsByTotalReceives($contract, $contract->receivesInPocket(false)->get()->sum('amount'));
            $this->successAlert(null, 'اقساط با موفقیت ثبت شد');
            return $this->redirect(route('receives.create', $contract));
        } catch (Exception $exception) {
            return back()->withErrors($exception->getMessage());
        }
    }
}
