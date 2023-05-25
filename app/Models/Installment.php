<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    use HasFactory;
    protected $fillable = ['contract_id', 'amount', 'desc', 'status', 'type', 'due_at', 'postponed_at'];


    protected function amount() : Attribute
    {
        return Attribute::make(
            set: fn (?string $value) => fix_number($value),
        );
    }

    protected function amountStr() : Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => number_format($attributes['amount']),
        );
    }

    protected function dueAt() : Attribute
    {
        return Attribute::make(
            set: fn ($value) => jdate()->fromFormat('Y/m/d', $value)->toCarbon(),
            get: fn ($value, $attributes) => jdate($attributes['due_at'])->format('Y/m/d'),
        );
    }
}

