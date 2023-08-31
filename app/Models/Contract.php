<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['customer_id', 'company_id', 'name', 'desc', 'draft', 'financial_status', 'contract_status', 'total_price', 'payable', 'advance_payment', 'installments_total_price', 'type', 'contract_number', 'period', 'remind_at', 'started_at', 'signed_at', 'canceled_at', 'expired_at', 'archived'];

    protected static function boot()
    {
        parent::boot();

        // soft delete installment after deleting contract
        static::deleting(function ($contract) {
            $contract->installments()->delete();
        });

        static::addGlobalScope('started_at', function (Builder $builder) {
            $builder->orderByDesc('started_at');
        });
    }

    protected function totalPrice(): Attribute
    {
        return Attribute::make(
            set: fn($value) => fix_number($value),
        );
    }

    protected function totalPriceStr(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => number_format($attributes['total_price']),
        );
    }

    protected function payable(): Attribute
    {
        return Attribute::make(
            set: fn($value) => fix_number($value),
        );
    }

    protected function payableStr(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => number_format($attributes['payable']),
        );
    }

    protected function advancePayment(): Attribute
    {
        return Attribute::make(
            set: fn($value) => fix_number($value),
        );
    }

    protected function advancePaymentStr(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => number_format($attributes['advance_payment']),
        );
    }

    protected function installmentsTotalPrice(): Attribute
    {
        return Attribute::make(
            set: fn($value) => fix_number($value),
        );
    }

    protected function installmentsTotalPriceStr(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => number_format($attributes['installments_total_price']),
        );
    }

    protected function signedAt(): Attribute
    {
        return Attribute::make(
            set: fn($value) => jdate()->fromFormat('Y/m/d', $value)->toCarbon(),
            get: fn($value) => $value ? jdate($value)->format('Y/m/d') : null,
        );
    }

    protected function startedAt(): Attribute
    {
        return Attribute::make(
            set: fn($value) => jdate()->fromFormat('Y/m/d', $value)->toCarbon(),
            get: fn($value) => $value ? jdate($value)->format('Y/m/d') : null,
        );
    }

    protected function expiredAt(): Attribute
    {
        return Attribute::make(
            set: fn($value) => !empty($value) ? jdate()->fromFormat('Y/m/d', $value)->toCarbon() : null,
            get: fn($value) => $value ? jdate($value)->format('Y/m/d') : null,
        );
    }

    protected function canceledAt(): Attribute
    {
        return Attribute::make(
            set: fn($value) => !empty($value) ? jdate()->fromFormat('Y/m/d', $value)->toCarbon() : null,
            get: fn($value) => $value ? jdate($value)->format('Y/m/d') : null,
        );
    }

    protected function canceledAtCarbon(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => $attributes['canceled_at'],
        );
    }

    protected function totalReceives(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => $this->receivesInPocket()->sum('amount'),
        );
    }

    protected function totalRest(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => $this->total_price - $this->receivesInPocket()->sum('amount')
        );
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class)->withDefault([
            'name'   => 'نامعتبر',
            'mobile' => 'نامعبتر',
        ]);
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
    public function receivesInPocket($advancePayment = null, $canceledAt = null): HasMany
    {
        $receives = $this->hasMany(Receive::class);
        $receives = $receives->when($canceledAt, function ($query) use ($canceledAt) {
            $query->where(function ($q) use ($canceledAt) {
                $q->where('paid_at', '>=', $canceledAt)->orWhere('due_at', '>=', $canceledAt);
            });
        });

        if ($advancePayment) {
            $receivesInPocket = $receives
                ->where('advance_payment', $advancePayment)->where(function ($query) use ($advancePayment) {
                    $query->where('passed', true)
                        ->orWhere('type', 'deposit');
                });
        } else {
            $receivesInPocket = $receives
                ->where(function ($query) {
                    $query->where('passed', true)
                        ->orWhere('type', 'deposit');
                });
        }

        return $receivesInPocket;
    }

    /**
     * Installment that can be received. its not containing installments that are after canceled date
     *
     * @return HasMany
     */
    public function installmentsCollectible(): HasMany
    {
        $installmentsCollectible = $this->hasMany(Installment::class);
        $installmentsCollectible = $installmentsCollectible->where('collectible', true);
        return $installmentsCollectible;
    }

    public function debtorInstallments()
    {

        return $this->installments()->where('due_at', '<=', today())->where('status', 'billed')->where('collectible', true);
    }


    public function advancePaymentRel()
    {
        return $this->receives()->where('advance_payment', true)->first();
    }

    public function canceledInstallment()
    {
        return $this->installments()->where('type', 'canceled')->first();
    }


    public function getCurrentYearContract()
    {
        return $this->whereYear('signed_at', jdate()->fromFormat('Y/m/d', jdate()->now()->getYear() . '/01/01')->toCarbon())->get();
    }

    public function getLastYearContract()
    {
        return $this->whereYear('signed_at', jdate()->fromFormat('Y/m/d', jdate()->now()->subYears(1)->getYear() . '/01/01')->toCarbon())->get();
    }


    public function active()
    {
        return $this->whereNotNull('expired_at')->whereNotNull('canceled_at');
    }

    public function notArchived()
    {
        return $this->where('archived', '!=', true);
    }

    public function archived()
    {
        return $this->where('archived', '!=', false);
    }
}
