<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Traits\Alert;
use App\Traits\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;



class ArchiveController extends Controller
{

    use Redirect, Alert;
    public function archive(Contract $contract)
    {

        $contract->update([
            'archived' => !$contract->archived,
        ]);
        $this->successAlert();
        return back();
    }
}
