<?php

namespace App\Repositories\Details;

use App\Models\Card;


class CardDetail extends Detail
{
    protected $data;
    protected $cardName;
    public function getDetail($id)
    {
        $card = Card::query()->findOrFail($id);

        $this->cardName = $card->name;
        $this->data = $card->receives()->paginate(50);
    }


    public function renderView(array $mergeData = [])
    {
        return parent::renderView(['data'=>$this->data, 'cardName' => $this->cardName, ...$mergeData]);
    }
}
