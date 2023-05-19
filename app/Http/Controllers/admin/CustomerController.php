<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Services\CustomerService;
use App\Traits\Alert;
use App\Traits\Redirect;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    use Alert, Redirect;
    protected CustomerService $service;

    public function __construct()
    {
        $this->service = new CustomerService();
    }


    public function index()
    {
        $customers = Customer::query()->latest()->paginate(50);
        return view('admin.customers.index', compact('customers'));
    }


    public function create()
    {
        $formAttributes = (new CustomerService())->formAttributes();
        return view('admin.customers.create', compact('formAttributes'));
    }


    public function store(Request $request)
    {
        $service = $this->service;
        $service->storeOrUpdate($request->all());
        $this->successAlert(null, 'مشتری با موفقیت ثبت شد');

        return $this->redirect(route('customers.index'));

    }


    public function edit(Customer $customer)
    {
        $formAttributes = (new CustomerService())->formAttributes($customer);
        return view('admin.customers.edit', compact('customer', 'formAttributes'));
    }


    public function update(Request $request, Customer $customer)
    {
        $service = $this->service;
        $service->storeOrUpdate($request->all(), $customer);
        $this->successAlert(null, 'مشتری با موفقیت ویرایش شد');
        return back();
    }


    public function destroy(string $id)
    {
        $customer = Customer::query()->findOrFail($id);
        $customer->delete();
        $this->successAlert(null, 'مشتری با موفقیت حذف شد');
        return back();
    }
}
