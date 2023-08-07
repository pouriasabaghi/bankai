<?php

namespace App\Repositories\Contract;

use App\Models\Contract as ContractModel;

class Contract
{

    protected ContractModel $contract;
    public function getContractCancelReceiveByPeriod($contract, $when = 'after')
    {

        $operator = ">=";

        $this->contract->where('');
    }

    public function contract(ContractModel $contract)
    {
        $this->contract =  new ContractModel();
        return $this->contract;
    }

    public function query()
    {
        return ContractModel::query();
    }
}
