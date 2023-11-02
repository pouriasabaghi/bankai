<?php

namespace App\Helpers\Receives;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait ReceiveAttribute
{

    public function registerAttributes()
    {
        $this->amount();
        $this->amountStr();
        $this->paidAt();
        $this->dueAt();
        $this->createdAt();
        $this->receivedAt();
        $this->date();
        $this->typeStr();
    }

    public function amount(): Attribute
    {
        return Attribute::make(
            set: fn($value) => fix_number($value),
        );
    }

    public function amountStr(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => number_format($attributes['amount']),
        );
    }

    public function paidAt(): Attribute
    {
        return Attribute::make(
            set: fn($value) => jdate()->fromFormat('Y/m/d', $value)->toCarbon(),
            get: fn($value, $attributes) => !empty($value) ? jdate($value)->format('Y/m/d') : '',
        );
    }

    public function dueAt(): Attribute
    {
        return Attribute::make(
            set: fn($value) => jdate()->fromFormat('Y/m/d', $value)->toCarbon(),
            get: fn($value, $attributes) => !empty($value) ? jdate($value)->format('Y/m/d') : '',
        );
    }

    public function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => !empty($value) ? jdate($value)->format('Y/m/d') : '',
        );
    }

    public function receivedAt(): Attribute
    {
        return Attribute::make(
            set: fn($value) => jdate()->fromFormat('Y/m/d', $value)->toCarbon(),
            get: fn($value, $attributes) => !empty($value) ? jdate($value)->format('Y/m/d') : '',
        );
    }

    public function date(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => $attributes['type'] == 'check' ? jdate($attributes['due_at'])->format('Y/m/d') : jdate($attributes['paid_at'])->format('Y/m/d'),
        );
    }

    public function typeStr(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => $attributes['type'] == 'check' ? 'چک' : 'واریز',
        );
    }

    protected function statusClass(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => $attributes['type'] == 'deposit'
            ? 'bg-success'
            : ($attributes['passed'] == true
                ? 'bg-success'
                : ($attributes['due_at'] <= now()
                    ? 'bg-danger'
                    : 'bg-warning'
                )
            )
        );
    }
}
