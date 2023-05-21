<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'company_id', 'name', 'desc', 'financial_status', 'contract_status', 'total_price', 'type', 'contract_number', 'period', 'signed_at', 'canceled_at'];
}
