<?php

namespace App\Repositories\Reports;

use App\Models\Installment;
use App\Traits\PeriodType;

class InstallmentReport extends Report
{
    use PeriodType;
    protected $data; // stand for model
    protected string $periodTitle;

    public function getData($period)
    {
        $model = new Installment();
        $periodCarbon = $this->periodToCarbon($period, request()->start, request()->end);
        $this->periodTitle = $this->periodToString($period, $periodCarbon['start'], $periodCarbon['end']);
        $this->data = $model->debtorInstallments()->where(function ($query) use ($period, $periodCarbon) {
            switch ($period) {
                case 'day':
                    return  $query->whereDate('due_at', $periodCarbon['start']);
                    break;
                case 'week':
                case 'month':
                    return  $query->whereBetween('due_at', $periodCarbon);
                    break;
                case 'year':
                    return  $query->whereYear('due_at', $periodCarbon['start']);
                    break;
                case 'selected':
                    return  $query->whereBetween('due_at', $periodCarbon);
                    break;
                default:
                    throw new \Exception('Date period is not valid');
                    break;
            }
        })->with('contract')->paginate(50);
    }

    public function renderView(array $mergeData = [])
    {
        return parent::renderView(['periodTitle' => $this->periodTitle, ...$mergeData]);
    }
}
