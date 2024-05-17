<?php

namespace App\Http\Livewire;

use App\Models\Contract;
use App\Models\Customer;
use Livewire\Component;

class Search extends Component
{

    public $search;
    public $searchResult;
    public function render()
    {
        return view('livewire.search');
    }

    public function updated()
    {
        $keyword = $this->search;
        if ($this->search)
            $keyword = trim($this->search);

        $contact  = Contract::query()->where('name', 'LIKE', "%{$keyword}%")->orWhereHas('customer', function ($query) use ($keyword) {
            $query->where('name', 'LIKE', "%{$keyword}%");
        })->get();

        $this->searchResult = $contact;
    }
}
