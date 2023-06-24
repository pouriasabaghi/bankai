<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Installment extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = ['contract_id', 'amount', 'desc', 'status', 'type', 'collectible', 'due_at', 'postponed_at'];

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

    protected function amount(): Attribute
    {
        return Attribute::make(
            set: fn (?string $value) => fix_number($value),
        );
    }

    protected function amountStr(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => number_format($attributes['amount']),
        );
    }

    protected function dueAt(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => jdate()->fromFormat('Y/m/d', $value)->toCarbon(),
            get: fn ($value, $attributes) => jdate($attributes['due_at'])->format('Y/m/d'),
        );
    }

    protected function statusClass(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                // contract has canceled_at date so other installment that the time is farther than canceled_at date can't receive any more.
                // these logic check for this
                if ($this->contract->canceled_at) {
                    // due_at not arrived and it's not canceled: this installment is not collectible !!!
                    if ($attributes['due_at'] > $this->contract->canceled_at_carbon && $attributes['type'] != 'canceled') {
                        return 'list-group-item-secondary opacity-50';
                    }
                    // due_at not arrived and it's canceled payment: this installment is  collectible +++
                    elseif ($attributes['due_at'] > $this->contract->canceled_at_carbon && $attributes['type'] == 'canceled' && $attributes['status'] == 'billed') {
                        return 'list-group-item-warning';
                    }
                    // due_at is arrived and it's billed: this installment is  collectible +++
                    elseif ($attributes['due_at'] <= today() && $attributes['status'] == 'billed') {
                        return 'list-group-item-danger';
                    }
                    // due_at is not arrived and it's billed: this installment is  collectible +++
                    elseif ($attributes['due_at'] > today() && $attributes['status'] == 'billed') {
                        return 'list-group-item-warning';
                    }
                    // it is paid: this installment is  collectible +++
                    else {
                        return 'list-group-item-success';
                    }
                }

                // contract isn't canceled
                if ($attributes['due_at'] > today()) {
                    if ($attributes['status'] == 'paid') {
                        return 'list-group-item-success';
                    } else {
                        return 'list-group-item-warning';
                    }
                } else {
                    if ($attributes['due_at'] <= today() && $attributes['status'] == 'billed') {
                        return 'list-group-item-danger';
                    } else {
                        return 'list-group-item-success';
                    }
                }
            }

        );
    }

    protected function statusDateClass(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                // contract has canceled_at date so other installment that the time is farther than canceled_at date can't receive any more.
                // these logic check for this
                if ($this->contract->canceled_at) {
                    // due_at not arrived and it's not canceled: this installment is not collectible !!!
                    if ($attributes['due_at'] > $this->contract->canceled_at_carbon && $attributes['type'] != 'canceled') {
                        return 'list-group-item-secondary opacity-50';
                    }
                    // due_at not arrived and it's canceled payment: this installment is  collectible +++
                    elseif ($attributes['due_at'] > $this->contract->canceled_at_carbon && $attributes['type'] == 'canceled' && $attributes['status'] == 'billed') {
                        return 'list-group-item-warning';
                    }
                    // due_at is arrived and it's billed: this installment is  collectible +++
                    elseif ($attributes['due_at'] <= today() && $attributes['status'] == 'billed') {
                        return 'list-group-item-danger';
                    }
                    // due_at is not arrived and it's billed: this installment is  collectible +++
                    elseif ($attributes['due_at'] > today() && $attributes['status'] == 'billed') {
                        return 'list-group-item-warning';
                    }
                    // it is paid: this installment is  collectible +++
                    else {
                        return 'list-group-item-success';
                    }
                }

                // contract isn't canceled
                if ($attributes['due_at'] > today()) {
                    if ($attributes['status'] == 'paid') {
                        return 'list-group-item-success';
                    } else {
                        return 'list-group-item-warning';
                    }
                } else {
                    if ($attributes['due_at'] <= today() && $attributes['status'] == 'billed') {
                        return 'list-group-item-danger';
                    } else {
                        return 'list-group-item-success';
                    }
                }
            }
        );
    }
}
