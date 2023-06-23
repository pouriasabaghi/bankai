<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['customer_id', 'company_id', 'name', 'desc', 'financial_status', 'contract_status', 'total_price', 'advance_payment', 'installments_total_price', 'type', 'contract_number', 'period', 'started_at', 'signed_at', 'canceled_at'];


    protected function totalPrice(): Attribute
    {
        return Attribute::make(
            set: fn ($value) =>  fix_number($value),
        );
    }

    protected function totalPriceStr(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => number_format($attributes['total_price']),
        );
    }

    protected function advancePayment(): Attribute
    {
        return Attribute::make(
            set: fn ($value) =>  fix_number($value),
        );
    }

    protected function advancePaymentStr(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => number_format($attributes['advance_payment']),
        );
    }

    protected function installmentsTotalPrice(): Attribute
    {
        return Attribute::make(
            set: fn ($value) =>  fix_number($value),
        );
    }

    protected function installmentsTotalPriceStr(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => number_format($attributes['installments_total_price']),
        );
    }

    protected function signedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) =>  jdate($value)->format('Y/m/d'),
        );
    }

    protected function startedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) =>  jdate($value)->format('Y/m/d'),
        );
    }

    protected function canceledAt(): Attribute
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


    public function receives()
    {
        return $this->hasMany(Receive::class);
    }

    /**
     * return passed check and received deposit
     *
     * @param boolean|string $advancePayment
     * @return HasMany
     */
    public function receivesInPocket($advancePayment = null): HasMany
    {
        $receives = $this->receives();
        if (is_bool($advancePayment)) {
            $receivesInPocket = $receives->where('advance_payment', $advancePayment)->where(function ($query) use ($advancePayment) {
                $query->where('passed', true)
                ->orWhere('type', 'deposit');
            });
        } else {
            $receivesInPocket = $receives->where(function ($query) {
                $query->where('passed', true)
                    ->orWhere('type', 'deposit');
            });
        }


        return $receivesInPocket;
    }

    public function advancePaymentRel()
    {
        return $this->receives()->where('advance_payment', true)->first();
    }
}
