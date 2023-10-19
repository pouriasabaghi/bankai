<?php

namespace App\Repositories\Reports;

use App\Models\Receive;
use App\Traits\PeriodType;

class ReceiveReport extends Report
{
    use PeriodType;
    protected $data; // stand for model
    protected string $periodTitle;

    public function getData($period)
    {
        $model = new Receive();
        $periodCarbon = $this->periodToCarbon($period, request()->start, request()->end);
        $this->periodTitle = $this->periodToString($period, $periodCarbon['start'], $periodCarbon['end']);
        $this->data = $model->receivesInPocket()->where(function ($query) use ($period, $periodCarbon) {
            switch ($period) {
                case 'day':
                    return  $query->whereDate('paid_at', $periodCarbon['start'])
                        ->orWhereDate('due_at', today());
                    break;
                case 'week':
                    return  $query->whereBetween('paid_at', $periodCarbon)
                        ->orWhereBetween('due_at', $periodCarbon);
                    break;
                case 'month':
                    return  $query->whereBetween('paid_at', $periodCarbon)
                        ->orWhereBetween('due_at', $periodCarbon);
                    break;
                case 'year':
                    return  $query->whereYear('paid_at', $periodCarbon['start'])
                        ->orWhereYear('due_at', $periodCarbon['start']);
                    break;
                case 'selected':
                    return  $query->whereBetween('paid_at', $periodCarbon)
                        ->orWhereBetween('due_at', $periodCarbon);
                    break;
                default:
                    throw new \Exception('Date period is not valid');
                    break;
            }
        })->with('notArchivedContract')->paginate(50);
    }

    public function renderView(array $mergeData = [])
    {
        return parent::renderView(['periodTitle' => $this->periodTitle, ...$mergeData]);
    }
}
