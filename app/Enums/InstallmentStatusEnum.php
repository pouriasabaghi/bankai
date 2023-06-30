<?php

namespace App\Enums;

enum InstallmentStatusEnum: string
{
    case Billed = 'billed';
    case Paid = 'paid';

    public function toString()
    {
        return match ($this) {
            self::Billed => 'تسویه نشده',
            self::Paid => 'تسویه شده',
            default => 'تسویه نشده',
        };
    }


    public function statusColor()
    {
        return match ($this) {
            self::Billed => 'text-danger',
            self::Paid => 'text-success',
            default => 'text-danger',
        };
    }
}
