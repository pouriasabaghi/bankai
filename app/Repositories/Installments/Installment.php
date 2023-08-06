<?php

namespace App\Repositories\Installments;

use App\Models\Installment as InstallmentModel;
use Illuminate\Database\Eloquent\Builder;
class Installment {
    /**
     * return installment that is collectible and not installments from a canceled contract
     *
     * @return Builder
     */
    public function collectible() : Builder{
        return $this->query()->where('collectible', true);
    }

    public function query(){
        return InstallmentModel::query();
    }
}
