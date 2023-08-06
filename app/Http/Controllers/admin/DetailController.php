<?php

namespace App\Http\Controllers\admin;

use App\Factories\DetailFactory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    public function getDetail(Request $request, $type, $id)
    {
        $detailRepoObject = "App\Repositories\Details\\" . ucfirst($type) . "Detail";
        $model = "App\Models\\" . ucfirst($type);
        $detail = DetailFactory::makeDetail($detailRepoObject, new $model,'admin.details.index');
        $detail->getDetail($id);
        return $detail->renderView(['directory' => $request->directory]);
    }
}
