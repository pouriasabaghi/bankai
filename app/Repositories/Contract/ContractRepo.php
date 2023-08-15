<?php

namespace App\Repositories\Contract;

use App\Models\Contract;
use Illuminate\Database\Eloquent\Builder;
class ContractRepo  {


    protected $model;

    public function __construct(Contract $model)
    {
        $this->model = $model;
    }


    public function getCurrentYearContract(){
        return $this->model->whereYear('signed_at', jdate()->fromFormat('Y/m/d', jdate()->now()->getYear().'/01/01')->toCarbon())->get();
    }

    public function getLastYearContract(){
        return $this->model->whereYear('signed_at', jdate()->fromFormat('Y/m/d', jdate()->now()->subYears(1)->getYear().'/01/01')->toCarbon())->get();
    }



    public function query(){
        return Contract::query();
    }
}
