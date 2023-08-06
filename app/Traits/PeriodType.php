<?php

namespace App\Traits;

use Carbon\Carbon;
use Exception;

trait PeriodType
{
    protected $formatType = 'Y/m/d';

    /**
     * return period in readable string
     *
     * @param string $period
     * @param Carbon|null $start
     * @param Carbon|null $end
     * @return string
     */
    public function periodToString(string $period, ?Carbon $start = null, ?Carbon $end = null): string
    {
        return match ($period) {
            'day' => ' در تاریخ ' . jdate()->now()->format($this->formatType),
            'week' => ' از تاریخ ' .  jdate($start)->format($this->formatType) . ' تا ' . jdate($end)->format($this->formatType),
            'month' => 'از تاریخ ' . jdate($start)->format($this->formatType) . ' تا ' . jdate($end)->format($this->formatType),
            'year' => 'از تاریخ ' . jdate($start)->format($this->formatType),
            default => throw new Exception("period didn't found")
        };
    }

    /**
     * return carbon date base on persian date; fix first day of week and month and year
     *
     * @param string $period
     * @return Carbon|array
     */
    public function periodToCarbon(string $period, $start = null, $end = null) : Carbon|array
    {
        switch ($period) {
            case 'day':
                return today();
                break;
            case 'week':
                return [
                    'start' => jdate()->getFirstDayOfWeek()->toCarbon(),
                    'end' => jdate()->getFirstDayOfWeek()->addDays(6)->toCarbon()
                ];
                break;
            case 'month':
                return [
                    'start' => jdate()->now()->getFirstDayOfMonth()->toCarbon(),
                    'end' => jdate()->now()->getFirstDayOfMonth()->addDays(jdate()->getMonth() > 6 ? 29 : 30)->toCarbon(),
                ];
                break;
            case 'year':
                return [
                    'start' => jdate()->now()->getFirstDayOfYear()->toCarbon(),
                    'end' => now(),
                ];
                break;
            default:
                throw new Exception('Period to carbon method: no valid period found');
        }
    }
}
