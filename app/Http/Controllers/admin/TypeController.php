<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Type;
use App\Traits\Alert;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    use Alert;
    public function index()
    {
        $types = Type::query()->latest()->paginate(50);
        return view('admin.types.index', compact('types'));
    }

    public function store(Request $request)
    {
        Type::create([
            'name' => $request->name,
        ]);
        $this->successAlert();
        return back();
    }

    public function destroy(string $id)
    {
        $type = Type::query()->findOrFail($id);
        $type->delete();
        $this->successAlert();
        return back();
    }
}
