<?php

namespace App\Http\Controllers\admin;

use App\Factories\DetailFactory;
use App\Http\Controllers\Controller;
use App\Models\Receive;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    public function getDetail(Request $request, $type, $id)
    {
        $detailRepoObject = "App\Repositories\Details\\" . ucfirst($type) . "Detail";
        $model            = "App\Models\\" . ucfirst($type);
        $detail           = DetailFactory::makeDetail($detailRepoObject, new $model, 'admin.details.index');
        $detail->getDetail($id);
        return $detail->renderView(['directory' => $request->directory]);
    }

    public function getFilledDetail(Request $request, $type)
    {
        $type             = $request->type;
        $model            = "App\Models\\" . ucfirst($type);
        $detailRepoObject = "App\Repositories\Details\\" . ucfirst($type) . "Detail";
        $detail           = DetailFactory::makeDetail($detailRepoObject, new $model, 'admin.details.index');

        $receivesIds = json_decode($request->receives);
        $data        = Receive::whereIn('id', $receivesIds)->paginate(50);
        $cardName = $request->cardName;
        return $detail->renderView(['directory' => $request->directory, 'data' => $data, 'cardName' => $cardName]);
    }
}
