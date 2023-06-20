<?php

namespace App\Services;

use App\Models\Service;

class ServiceService
{
    /**
     * Collection of attributes
     *
     * @param Service|null $service
     * @return array
     */
    public function formAttributes(?Service $service = null) : array
    {
        if ($service) {
            $action = route('services.update', $service->id);
            $method = 'PUT';
            $form = 'update';
            $isUpdate = true ;
        }else{
            $action = route('services.store');
            $method = 'POST';
            $form = 'store';
            $isUpdate = false;
        }

        return compact('action', 'method', 'form', 'isUpdate');
    }


    /**
     * store or update
     *
     * @param array $data
     * @param Service|null $service
     * @return Service
     */
    public function storeOrUpdate(array $data, ?Service $service = null) : Service
    {
        $preparedData = [
            'name'=>$data['name'],
        ];

        if ($service) {
            $service->fill($preparedData);
            $service->save();
        }else{
            $service = Service::create($preparedData);
        }

        return $service ;
    }

}
