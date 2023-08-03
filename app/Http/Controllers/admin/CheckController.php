<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Receive;
use Illuminate\Http\Request;

class CheckController extends Controller
{
    public function index(){
        $checks = (new Receive())->checks()->get()->groupBy('due_at');
        return view('admin.checks.index', compact('checks'));
    }
}
