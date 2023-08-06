<?php

namespace App\Repositories\Details;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Detail
{
    protected $data;
    protected $view;


    public function __construct(Builder|Model $data, $view)
    {
        $this->data = $data;
        $this->view = $view;
    }

    public function getData($id)
    {
        return $this->data->where('id', $id);
    }


    public function renderView(array $mergeData = [])
    {
        return view($this->view, ['data' => $this->data, ...$mergeData]);
    }
}
