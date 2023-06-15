<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function customers()
    {
        return $this->belongsToMany(Customer::class);
    }

    protected function customersStr() : Attribute {
      return Attribute::make(
        get: fn (mixed $value, array $attributes)=> $this->customers->pluck('name')->implode(', '),
      );
    }

    protected function getCustomersIdsAttribute()
    {
        return $this->customers->pluck('id')->toArray();
    }
}
