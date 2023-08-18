<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'desc', 'phone', 'mobile'];

    public function companies()
    {
        return $this->belongsToMany(Company::class);
    }

    protected function mobile(): Attribute
    {
        return Attribute::make(
            set: fn (?string $value) => fix_number($value),
        );
    }

    public function contracts(){
        return $this->hasMany(Contract::class);
    }


    public function receives(){
        return $this->hasMany(Receive::class);
    }
}
