<?php

namespace App\Enums ;

enum ContractStatusEnum :string
{
    case Progress = 'progress';
    case Finished = 'finished';
    case Canceled = 'canceled';
    case Renewal = 'renewal';

}
