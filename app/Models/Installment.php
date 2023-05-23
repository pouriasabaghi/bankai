<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    use HasFactory;
    protected $fillable = ['contract_id', 'amount', 'desc', 'status', 'type', 'due_at', 'postponed_at'];
}
