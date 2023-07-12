<?php

namespace  App\Enums;



enum InstallmentKindEnum: string
{
    case Deposit = 'deposit';
    case Check = 'check';


    public function toString()
    {
        return match ($this) {
            self::Deposit => 'نقدی',
            self::Check => 'چک',
            default => 'ثبت نشده',
        };
    }
}
