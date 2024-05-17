<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    public $fillable = [
        'from',
        'to',
        'amount',
        'desc',
        'cost_id'
    ];


    protected function amount(): Attribute
    {
        return Attribute::make(
            set: fn(?string $value) => fix_number($value),
        );
    }

    protected function amountStr(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => number_format($attributes['amount']),
        );
    }


    public function fromCard()
    {
        return $this->belongsTo(Card::class, 'from', 'id');
    }

    public function cost(){
        return $this->belongsTo(Cost::class);
    }

}
