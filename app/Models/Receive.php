<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receive extends Model
{
    use HasFactory;
    protected $fillable = ['contract_id', 'card_id', 'company_id', 'type', 'origin', 'amount', 'bank_name', 'branch_name', 'branch_code', 'owner', 'serial_number', 'paid_at', 'received_at', 'due_at'];
}
