<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Traits\Alert;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    use Alert;
    public function index()
    {
        $services = Service::query()->latest()->paginate(50);
        return view('admin.services.index', compact('services'));
    }

    public function store(Request $request)
    {
        Service::create(['name' => $request->name]);
        $this->successAlert();
        return back();
    }

    public function destroy(string $id)
    {
        $service = Service::query()->findOrFail($id);
        $service->delete();
        $this->successAlert();
        return back();
    }
}
