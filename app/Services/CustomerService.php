<?php

namespace App\Services;

use App\Models\Customer;
use Illuminate\Support\Collection;

class CustomerService
{
    /**
     * Collection of attributes
     *
     * @param Customer|null $customer
     * @return array
     */
    public function formAttributes(?Customer $customer = null) : array
    {
        if ($customer) {
            $action = route('customers.update', $customer->id);
            $method = 'PUT';
            $form = 'update';
        }else{
            $action = route('customers.store');
            $method = 'POST';
            $form = 'store';
        }

        return compact('action', 'method', 'form');
    }


    public function storeOrUpdate(array $data, ?Customer $customer = null) : Customer
    {
        $preparedData = [
            'name'=>$data['name'],
            'mobile'=>$data['mobile'],
            'phone'=>$data['phone'],
            'desc'=>$data['desc'],
        ];

        if ($customer) {
            $customer->fill($preparedData);
            $customer->save();
        }else{
            $customer = Customer::create($preparedData);
        }

        return $customer ;
    }
}
