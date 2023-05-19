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
        }else{
            $action = route('customers.store');
            $method = 'POST';
        }

        return compact('action', 'method');
    }


    public function storeOrUpdate(array $data, ?Customer $customer = null)
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
    }
}
