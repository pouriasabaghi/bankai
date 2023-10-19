<?php

namespace App\Models;

use App\Helpers\Installments\InstallmentAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;

class Installment extends Model
{
    use HasFactory, Notifiable, SoftDeletes, InstallmentAttribute;
    protected $fillable = ['contract_id', 'amount', 'desc', 'status', 'type', 'kind', 'collectible', 'due_at', 'postponed_at'];

    public function __construct()
    {
        parent::boot();
        static::addGlobalScope('due_at', function (Builder $builder) {
            $builder->orderBy('due_at');
        });
        $this->registerAttributes();
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function notArchivedContract()
    {
        return $this->belongsTo(Contract::class)->where('archived', false)->withDefault([
            'name' => 'قرارداد نامعتبر',
        ]);
    }

    public function getContract()
    {
        return $this->contract;
    }

    public function debtorInstallments()
    {

        return $this->where('due_at', '<=', today())->where('status', 'billed')->where('collectible', true);
    }

    public function collectible() : Builder{
        return $this->query()->where('collectible', true);
    }

    public function allNotPaidInstallments()
    {

        return $this->where('status', 'billed')->where('collectible', true);
    }
}
