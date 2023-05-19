<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Customer;
use App\Services\CompanyService;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    protected CompanyService  $service ;

    public function __construct()
    {
        $this->service = new CompanyService() ;
    }

    public function index()
    {
        $companies = Company::query()->with('customer')->latest()->paginate(50);
        return view('admin.companies.index', compact('companies'));
    }


    public function create()
    {
        $service = $this->service ;
        $formAttributes = $service->formAttributes();
        $customers = Customer::query()->get();
        return view('admin.companies.create', compact('formAttributes','customers'));
    }


    public function store(Request $request)
    {
        //
    }


    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(string $id)
    {
        //
    }
}
