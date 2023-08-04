<?php

namespace App\Repositories\Installments;

use App\Models\Installment as InstallmentModel;
use Illuminate\Database\Eloquent\Builder;
class Installment {
    public function query(){
        return InstallmentModel::query();
    }
}
