<?php

namespace App\Services;

use Illuminate\Support\Collection;
use \App\Models\Cost;

class CostService
{

    /**
     * Collection of attributes
     *
     * @param \App\Models\Cost|null $cost
     * @return array
     */
    public function formAttributes(?Cost $cost = null): array
    {
        if ($cost) {
            $action = route('costs.update', $cost->id);
            $method = 'PUT';
            $form = 'update';
        } else {
            $action = route('costs.store');
            $method = 'POST';
            $form = 'store';
        }

        return compact('action', 'method', 'form');
    }


    public function storeOrUpdate(array $data, ?Cost $cost = null): Cost
    {
        $preparedData = [
            'name' => $data['name'],
            'desc' => $data['desc'],
        ];

        if ($cost) {
            $cost->fill($preparedData);
            $cost->save();
        } else {
            $cost = Cost::create($preparedData);
        }

        return $cost;
    }

}
