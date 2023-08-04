<?php

namespace App\Repositories\Reports;

class ReceiveReport extends Report
{
    protected $data;
    protected string $periodTitle;

    public function getData($period)
    {
        $receiveRepo = $this->data->getRepo();

        $this->data = $receiveRepo->receivesInPocket()->where(function ($query) use ($period) {
            $formatType = 'Y/m/d';
            switch ($period) {
                case 'day':
                    $this->periodTitle = ' در تاریخ ' . jdate()->now()->format($formatType);

                    return  $query->whereDate('paid_at', today())
                        ->orWhereDate('due_at', today());
                    break;

                case 'week':
                    $startOfWeekSolarHijri = jdate()->getFirstDayOfWeek()->toCarbon();
                    $endOfWeekSolarHijri = jdate()->getFirstDayOfWeek()->addDays(6)->toCarbon();

                    $this->periodTitle = ' از تاریخ ' .  jdate($startOfWeekSolarHijri)->format($formatType) . ' تا ' . jdate($endOfWeekSolarHijri)->format($formatType);

                    return  $query->whereBetween('paid_at', [$startOfWeekSolarHijri, $endOfWeekSolarHijri])
                        ->orWhereBetween('due_at', [$startOfWeekSolarHijri, $endOfWeekSolarHijri]);
                    break;

                case 'month':

                    $firstDayOfSolarHijriMonth = jdate()->now()->getFirstDayOfMonth();
                    $lastDayOfSolarHijriMonth = $firstDayOfSolarHijriMonth->addDays(jdate()->getMonth() > 6 ? 29 : 30);
                    $firstDayOfMonthToCarbon = $firstDayOfSolarHijriMonth->toCarbon();
                    $this->periodTitle = 'از تاریخ ' . $firstDayOfSolarHijriMonth->format($formatType) . ' تا ' . $lastDayOfSolarHijriMonth->format($formatType);

                    return  $query->whereBetween('paid_at', [$firstDayOfMonthToCarbon, now()])
                        ->orWhereBetween('due_at', [$firstDayOfMonthToCarbon, now()]);
                    break;

                case 'year':
                    $firstDayOfSolarHijriYear =  jdate()->now()->getFirstDayOfYear();
                    $firstDayToCarbon = $firstDayOfSolarHijriYear->toCarbon();
                    $this->periodTitle = 'از تاریخ ' . $firstDayOfSolarHijriYear->format($formatType);

                    return  $query->whereYear('paid_at', $firstDayToCarbon)
                        ->orWhereYear('due_at', $firstDayToCarbon);
                    break;
                default:
                    throw new \Exception('تاریخ نامعبتر می‌باشد.');
                    break;
            }
        })->with('contract')->get();
    }

    public function renderView(array $mergeData = [])
    {
        return parent::renderView(['periodTitle' => $this->periodTitle, ...$mergeData]);
    }
}
