<?php

namespace App\Repositories\Reports;

use App\Models\Card;
use App\Models\Receive;
use App\Traits\PeriodType;

class ReceiveReport extends Report
{
    use PeriodType;
    protected $data; // stand for model
    protected string $periodTitle;
    protected $total = 0;
    protected $cards;
    public function getData($period)
    {
        $model             = new Receive();
        $periodCarbon      = $this->periodToCarbon($period, request()->start, request()->end);
        $this->periodTitle = $this->periodToString($period, $periodCarbon['start'], $periodCarbon['end']);
        $receives          = $model->receivesInPocket()->where(function ($query) use ($period, $periodCarbon) {
            switch ($period) {
                case 'day':
                    return $query->whereDate('paid_at', $periodCarbon['start'])
                        ->orWhereDate('due_at', today());
                    break;
                case 'week':
                    return $query->whereBetween('paid_at', $periodCarbon)
                        ->orWhereBetween('due_at', $periodCarbon);
                    break;
                case 'month':
                    return $query->whereBetween('paid_at', $periodCarbon)
                        ->orWhereBetween('due_at', $periodCarbon);
                    break;
                case 'year':
                    return $query->whereBetween('paid_at', $periodCarbon)
                        ->orWhereBetween('due_at', $periodCarbon);
                    break;
                case 'selected':
                    return $query->whereBetween('paid_at', $periodCarbon)
                        ->orWhereBetween('due_at', $periodCarbon);
                    break;
                default:
                    throw new \Exception('Date period is not valid');
                    break;
            }
        })->with('notArchivedContract');


        $receivesGroupedByCard = $receives->get()->groupBy('card_id');
        $this->cards           = $receivesGroupedByCard->mapWithKeys(function ($receives, $index) {
            $card = Card::firstWhere('id', $index);
            return [
                $index => [
                    'amount' => $receives->sum('amount'),
                    'receives'=>$receives->pluck('id'),
                    'name'   => Card::firstWhere('id', $index)->name ?? 'نامعتبر',
                    'link'   => !empty($card->id) ? route('details.filled', ['type' => 'card', 'id' => $index]) : null,
                ],
            ];
        });

        $this->total = $receives->sum('amount');
        $this->data  = $receives->paginate(50);
    }

    public function renderView(array $mergeData = [])
    {
        return parent::renderView(['periodTitle' => $this->periodTitle, 'total' => $this->total, 'cards' => $this->cards, ...$mergeData]);
    }
}
