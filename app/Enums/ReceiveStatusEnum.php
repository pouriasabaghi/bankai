<?php

namespace App\Enums;

enum ReceiveStatusEnum: string
{
    case Passed =  '1';
    case NotPassed = '0';

    public function statusColor()
    {
        return match ($this) {
            self::Passed => 'bg-success',
            self::NotPassed => 'bg-warning',
            default => '',
        };
    }
}
