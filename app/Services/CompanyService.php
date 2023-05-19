<?php

namespace App\Services;

use App\Models\Company;

class CompanyService
{
    /**
     * Collection of attributes
     *
     * @param Customer|null $customer
     * @return array
     */
    public function formAttributes(Company $company = null): array
    {
        if ($company) {
            $action = route('companies.update', $company->id);
            $method = 'PUT';
            $form = 'update';
        } else {
            $action = route('companies.store');
            $method = 'POST';
            $form = 'store';
        }

        return compact('action', 'method', 'form');
    }


    /**
     * store or update Company
     *
     * @param array $data
     * @param Company|null $customer
     * @return Company
     */
    public function storeOrUpdate(array $data, Company $company = null): Company
    {
        $preparedData = [
            'name' => $data['name'],
            'customer_id' => intval($data['customer_id']),
        ];

        if ($company) {
            $company->fill($preparedData);
            $company->save();
        } else {
            $company = Company::create($preparedData);
        }

        return $company;
    }
}
