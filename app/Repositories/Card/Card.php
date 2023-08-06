<?php

namespace App\Repositories\Card;

use App\Models\Card  as CardModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Card {
    /**
     * Get card receives list
     *
     * @param int $id
     * @return HasMany
     */
    public function receivesById(int $id) : HasMany{
        return $this->query()->findOrFail($id)->receives();
    }


    public function card($id){
        return $this->query()->findOrFail($id);
    }

    public function query(){
        return CardModel::query();
    }
}
