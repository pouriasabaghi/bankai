<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Installment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {
        $debtorInstallments = Installment::query()->where('due_at', '<=', now())->where('status', 'billed')->with('contract')->get();
        return view('admin.dashboard.index', compact('debtorInstallments'));
    }
}
