<?php

namespace App\Models;

use App\Helpers\Receives\ReceiveAttribute;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receive extends Model
{
    use HasFactory, ReceiveAttribute;
    protected $fillable = ['contract_id', 'card_id', 'company_id', 'customer_id', 'type', 'origin', 'amount', 'bank_name', 'branch_name', 'branch_code', 'desc', 'passed', 'serial_number', 'advance_payment', 'paid_at', 'received_at', 'due_at'];

    public function __construct()
    {
        $this->registerAttributes();
    }


    public function uncollectedChecks()
    {
        return $this->where('due_at', '<=', today())->where('type', 'check')->where('passed', false);
    }

    public function checks()
    {
        return $this->where('type', 'check');
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }


    public function card(){
        return $this->belongsTo(Card::class)->withDefault([
            'name'=>'کارت نامعبتر'
        ]);
    }
}
