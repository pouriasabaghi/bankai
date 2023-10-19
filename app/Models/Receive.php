<?php

namespace App\Models;

use App\Helpers\Receives\ReceiveAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Receive extends Model
{
    use HasFactory, ReceiveAttribute;
    protected $fillable = ['contract_id', 'card_id', 'company_id', 'customer_id', 'type', 'origin', 'amount', 'bank_name', 'branch_name', 'branch_code', 'desc', 'passed', 'serial_number', 'advance_payment', 'paid_at', 'received_at', 'due_at'];

    public function __construct()
    {
        parent::boot();
        static::addGlobalScope('due_at', function (Builder $builder) {
            $builder->orderBy('due_at');
        });
        $this->registerAttributes();
    }


    public function uncollectedChecks()
    {
        return $this->where('due_at', '<=', today()->addWeek())->where('type', 'check')->where('passed', false);
    }

    public function checks()
    {
        return $this->where('type', 'check');
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class)->withDefault([
            'name' => 'قرارداد نامعتبر',
        ]);
    }

    public function notArchivedContract()
    {
        return $this->belongsTo(Contract::class)->where('archived', false)->withDefault([
            'name' => 'قرارداد نامعتبر',
        ]);
    }

    public function card()
    {
        return $this->belongsTo(Card::class)->withDefault([
            'name' => 'کارت نامعبتر'
        ]);
    }

    /**
     * return receives that are deposits or passed check
     *
     * @return Builder
     */
    public function receivesInPocket(): Builder
    {
        $receives = $this->query()->where(function ($query) {
            $query->where('passed', true)
                ->orWhere('type', 'deposit');
        });

        return $receives;
    }
}
