<?php

namespace App\Helpers\Installments;

use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Helpers\Installments\InstallmentAM;

trait InstallmentAttribute{


    public abstract function getContract();

    public function registerAttributes()
    {
        $this->amount();
        $this->amountStr();
        $this->dueAt();
        $this->statusClass();
        $this->statusDateClass();
    }

    protected function amount(): Attribute
    {
        return Attribute::make(
            set: fn (?string $value) => fix_number($value),
        );
    }

    protected function amountStr(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => number_format(fix_number($attributes['amount'])),
        );
    }

    protected function dueAt(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => jdate()->fromFormat('Y/m/d', $value)->toCarbon(),
            get: fn ($value, $attributes) => jdate($attributes['due_at'])->format('Y/m/d'),
        );
    }

    protected function statusClass(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => InstallmentAM::getStatusClass($this->getContract(), $attributes)
        );
    }

    protected function statusDateClass(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => InstallmentAM::getStatusClass($this->getContract(), $attributes)
        );
    }
}
