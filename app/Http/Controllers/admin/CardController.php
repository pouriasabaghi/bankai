<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Services\CardService;
use App\Traits\Alert;
use App\Traits\Redirect;
use Illuminate\Http\Request;

class CardController extends Controller
{
    use Alert, Redirect;
    protected CardService $service;
    public function __construct()
    {
        $this->service = new CardService();
    }

    public function index()
    {
        $cards = Card::query()->latest()->paginate(50);
        return view('admin.cards.index', compact('cards'));
    }

    public function create()
    {
        $service = $this->service;
        $formAttributes = $service->formAttributes();
        return view('admin.cards.create', compact('formAttributes'));
    }

    public function store(Request $request)
    {
        $service = $this->service;
        $service->storeOrUpdate($request->all());
        $this->successAlert(null, 'شماره حساب با موفقیت ثبت شد');
        return $this->redirect(route('cards.index'));
    }

    public function edit(Card $card)
    {
        $service = $this->service;
        $formAttributes = $service->formAttributes($card);
        return view('admin.cards.edit', compact('formAttributes', 'card'));
    }

    public function update(Request $request, Card $card)
    {
        $service = $this->service;
        $service->storeOrUpdate($request->all(), $card);
        $this->successAlert(null, 'شماره حساب با موفقیت ویرایش شد');
        return back();
    }

    public function destroy(string $id)
    {
        $card = Card::query()->findOrFail($id);
        $card->delete();
        $this->successAlert(null, 'شماره حساب با موفقیت حذف شد');
        return back();
    }
}
