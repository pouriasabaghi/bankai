<?php

namespace App\Repositories\Details;

class CardDetail extends Detail
{
    protected $data;
    protected $cardName;
    public function getDetail($id)
    {
        $repo = $this->data->getRepo();

        $this->cardName = $repo->card($id)->name;
        $this->data = $repo->receivesById($id)->paginate(1);
    }


    public function renderView(array $mergeData = [])
    {
        return parent::renderView(['data'=>$this->data, 'cardName' => $this->cardName, ...$mergeData]);
    }
}
