<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Installment;
use App\Notifications\InstallmentNotification;
use App\Services\InstallmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class DashboardController extends Controller
{

    public function index()
    {
        $debtorInstallments = Installment::query()->where('due_at', '<=', now())->where('status', 'billed')->with('contract')->get();

        $debtorInstallments->each(function($installment, $key){
            Notification::send($installment,  new InstallmentNotification($installment));
        });


        dd('okk');
        return view('admin.dashboard.index', compact('debtorInstallments'));
    }
}
