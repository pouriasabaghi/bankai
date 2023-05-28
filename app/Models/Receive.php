<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receive extends Model
{
    use HasFactory;
    protected $fillable = ['contract_id', 'card_id', 'company_id','customer_id', 'type', 'origin', 'amount', 'bank_name', 'branch_name', 'branch_code', 'desc', 'serial_number', 'paid_at', 'received_at', 'due_at'];


    public function amount(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => fix_number($value),
        );
    }

    public function amountStr(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => number_format($attributes['amount']),
        );
    }

    public function paidAt(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => jdate()->fromFormat('Y/m/d', $value)->toCarbon(),
            get: fn ($value, $attributes) => !empty($value) ? jdate($value)->format('Y/m/d') : '',
        );
    }

    public function dueAt(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => jdate()->fromFormat('Y/m/d', $value)->toCarbon(),
            get: fn ($value, $attributes) => !empty($value) ? jdate($value)->format('Y/m/d') : '',
        );
    }

    public function receivedAt(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => jdate()->fromFormat('Y/m/d', $value)->toCarbon(),
            get: fn ($value, $attributes) => !empty($value) ? jdate($value)->format('Y/m/d') : '',
        );
    }

    public function date(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => $attributes['type'] == 'checked' ? jdate($attributes['due_at'])->format('Y/m/d') : jdate($attributes['paid_at'])->format('Y/m/d'),
        );
    }

    public function typeStr(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => $attributes['type'] == 'check' ? 'چک' : 'واریز',
        );
    }
}
