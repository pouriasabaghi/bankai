<?php

namespace App\Models;

use App\Helpers\Installments\InstallmentAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Installment extends Model
{
    use HasFactory, Notifiable, SoftDeletes, InstallmentAttribute;
    protected $fillable = ['contract_id', 'amount', 'desc', 'status', 'type', 'collectible', 'due_at', 'postponed_at'];

    public function __construct()
    {
        $this->registerAttributes();
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('due_at', function ($query) {
            $query->orderBy('due_at');
        });
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }


    public function getContract()
    {
        return $this->contract;
    }

    public function debtorInstallments()
    {
        return $this->where('due_at', '<=', today())->where('status', 'billed');
    }
}
