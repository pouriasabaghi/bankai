<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Customer;
use App\Services\CompanyService;
use App\Traits\Alert;
use App\Traits\Redirect;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    use Alert, Redirect;
    protected CompanyService  $service;

    public function __construct()
    {
        $this->service = new CompanyService();
    }

    public function index()
    {
        $companies = Company::query()->with('customer')->latest()->paginate(50);
        return view('admin.companies.index', compact('companies'));
    }


    public function create()
    {
        $service = $this->service;
        $formAttributes = $service->formAttributes();
        $customers = Customer::query()->get();
        return view('admin.companies.create', compact('formAttributes', 'customers'));
    }


    public function store(Request $request)
    {
        $service = $this->service;
        $service->storeOrUpdate($request->all());
        $this->successAlert();
        return $this->redirect(route('companies.index'));
    }


    public function edit(Company $company)
    {
        $service = $this->service;
        $formAttributes = $service->formAttributes($company);
        $customers = Customer::query()->get();
        return view('admin.companies.edit', compact('company', 'formAttributes', 'customers'));
    }


    public function update(Request $request, Company $company)
    {
        dd($request->all());
        $service = $this->service;
        $service->storeOrUpdate($request->all(), $company);
        $this->successAlert();
        return $this->redirect(route('companies.index'));
    }


    public function destroy(string $id)
    {
        $company = Company::query()->findOrFail($id);
        $company->delete();
        $this->successAlert();
        return back();
    }
}
