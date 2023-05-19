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

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $customers = Customer::query()->latest()->paginate(50);
        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $formAttributes = (new CustomerService())->formAttributes();
        return view('admin.customers.create', compact('formAttributes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $service = $this->service;
        $service->storeOrUpdate($request->all());
        $this->successAlert(null, 'مشتری با موفقیت ثبت شد');

        return $this->redirect(route('customers.index'), $request->stay_in_page );

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        $formAttributes = (new CustomerService())->formAttributes($customer);
        return view('admin.customers.edit', compact('customer', 'formAttributes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $service = $this->service;
        $service->storeOrUpdate($request->all(), $customer);
        $this->successAlert(null, 'مشتری با موفقیت ویرایش شد');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::query()->findOrFail($id);
        $customer->delete();
        //!!! if customer delete companies must delete to
        $this->successAlert(null, 'مشتری با موفقیت حذف شد');
        return back();
    }
}
