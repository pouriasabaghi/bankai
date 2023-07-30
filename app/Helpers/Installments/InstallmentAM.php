<?php

namespace App\Helpers\Installments;

use App\Models\Contract;

/**
 * AM: Accessor and mutator helper
 */

class InstallmentAM
{
    public static function getStatusClass(Contract $contract, $attributes) : string
    {

        // contract has canceled_at date so other installment that the time is farther than canceled_at date can't receive any more.
        // these logic check for this
        if ($contract->canceled_at) {
            // due_at not arrived and it's not canceled_installment; the whole contract canceled and this installment is not collectible !!!
            // $attributes['due_at'] > $contract->canceled_at_carbon && $attributes['type'] != 'canceled'
            if ($attributes['collectible'] == false) {
                return 'list-group-item-secondary opacity-50';
            }
            // due_at not arrived and it's canceled payment: this installment is  collectible +++
            elseif ($attributes['due_at'] > $contract->canceled_at_carbon && $attributes['type'] == 'canceled' && $attributes['status'] == 'billed') {
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
}
