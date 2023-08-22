<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $fillable= ['name', 'number', 'amount'] ;
    protected function amount(): Attribute
    {
        return Attribute::make(
            set: fn (?string $value) => fix_number($value),
        );
    }

    protected function amountStr(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => number_format($attributes['amount']) ,
        );
    }

    public function receives()  {
        return $this->hasMany(Receive::class);
    }

}
