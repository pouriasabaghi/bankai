<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Cost;
use App\Services\CostService;
use App\Traits\Alert;
use App\Traits\Redirect;
use Illuminate\Http\Request;

class CostController extends Controller
{
    use Alert, Redirect;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $costs = Cost::query()->latest()->paginate(50);
        return view('admin.costs.index', compact('costs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(CostService $service)
    {
        $formAttributes = $service->formAttributes();
        return view('admin.costs.create', compact('formAttributes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, CostService $service)
    {
        $service->storeOrUpdate($request->all());
        $this->successAlert(null, 'دسته‌ بندی با موفقیت ثبت شد');
        return $this->redirect(route('costs.index'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cost $cost, CostService $service)
    {
        $formAttributes = $service->formAttributes($cost);
        return view('admin.costs.edit', compact('formAttributes', 'cost'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cost $cost, CostService $service)
    {
        $service->storeOrUpdate($request->all(), $cost);
        $this->successAlert(null, 'دسته‌ بندی با موفقیت ویرایش شد');
        return $this->redirect(route('costs.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cost = Cost::findOrFail($id);
        $cost->delete();
        $this->successAlert(null, 'دسته‌ بندی با موفقیت حذف شد');
        return $this->redirect(route('costs.index'));
    }
}
