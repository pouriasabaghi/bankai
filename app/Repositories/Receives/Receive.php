<?php

namespace App\Repositories\Receives;

use App\Models\Receive as ReceiveModel;
use Illuminate\Database\Eloquent\Builder;
class Receive {
    /**
     * return receives that are deposits or passed check
     *
     * @return Builder
     */
    public function receivesInPocket() : Builder
    {
        $receives = $this->query()->where(function ($query) {
            $query->where('passed', true)
                ->orWhere('type', 'deposit');
        });

        return $receives;
    }

    public function query(){
        return ReceiveModel::query();
    }
}
