<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'company_id', 'name', 'desc', 'financial_status', 'contract_status', 'total_price', 'type', 'contract_number', 'period', 'signed_at', 'canceled_at'];


    protected function totalPrice() : Attribute
    {
        return Attribute::make(
            set: fn ($value) =>  fix_number($value),
        );
    }

    protected function totalPriceStr() : Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => number_format($attributes['total_price']),
        );
    }

    protected function signedAt() : Attribute
    {
        return Attribute::make(
            get: fn ($value) =>  jdate($value)->format('Y/m/d'),
        );
    }

    protected function canceledAt() : Attribute
    {
        return Attribute::make(
            get: fn ($value) =>  jdate($value)->format('Y/m/d'),
        );
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }


    public function services()
    {
        return $this->belongsToMany(Service::class);
    }


    public function installments()
    {
        return $this->hasMany(Installment::class);
    }
}
