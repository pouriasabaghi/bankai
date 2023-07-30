<?php

namespace App\Repositories\Reports;

use App\Interfaces\ReportInterface;
use Illuminate\Database\Eloquent\Builder;

class Report implements ReportInterface
{
    protected $data;
    protected $view;

    public function __construct(Builder $data, $view)
    {
        $this->data = $data;
        $this->view = $view;
    }

    public function getData()
    {
        return $this->data;
    }
    public function renderView()
    {
        return $this->view;
    }
}
