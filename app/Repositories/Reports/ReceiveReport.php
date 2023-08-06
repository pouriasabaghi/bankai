<?php

namespace App\Repositories\Reports;

use App\Traits\PeriodType;

class ReceiveReport extends Report
{
    use PeriodType;
    protected $data;
    protected string $periodTitle;

    public function getData($period)
    {
        $receiveRepo = $this->data->getRepo();

        $this->data = $receiveRepo->receivesInPocket()->where(function ($query) use ($period) {
            $periodCarbon = $this->periodToCarbon($period);
            switch ($period) {
                case 'day':
                    $this->periodTitle = $this->periodToString($period);
                    return  $query->whereDate('paid_at', $periodCarbon)
                        ->orWhereDate('due_at', today());
                    break;
                case 'week':
                    $this->periodTitle = $this->periodToString($period, $periodCarbon['start'], $periodCarbon['end']);

                    return  $query->whereBetween('paid_at', $periodCarbon)
                        ->orWhereBetween('due_at', $periodCarbon);
                    break;
                case 'month':
                    $this->periodTitle = $this->periodToString($period, $periodCarbon['start'], $periodCarbon['end']);

                    return  $query->whereBetween('paid_at', $periodCarbon)
                        ->orWhereBetween('due_at', $periodCarbon);
                    break;
                case 'year':

                    $this->periodTitle = $this->periodToString($period, $periodCarbon['start']);

                    return  $query->whereYear('paid_at', $periodCarbon['start'])
                        ->orWhereYear('due_at', $periodCarbon['start']);
                    break;
                default:
                    throw new \Exception('Date period is not valid');
                    break;
            }
        })->with('contract')->get();
    }

    public function renderView(array $mergeData = [])
    {
        return parent::renderView(['periodTitle' => $this->periodTitle, ...$mergeData]);
    }
}
