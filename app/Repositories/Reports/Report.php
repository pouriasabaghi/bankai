<?php

namespace App\Repositories\Reports;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class Report
{
    protected $data;
    protected $view;

    public function __construct(Builder|Model $data, $view)
    {
        $this->data = $data;
        $this->view = $view;
    }

    public function getData($period)
    {
        if ($this->data instanceof Model) {
            return $this->data::all();
        }

        return $this->data;
    }
    public function renderView(array $mergeData = [])
    {
        return view($this->view, ['data'=> $this->data, ...$mergeData]);
    }
}
