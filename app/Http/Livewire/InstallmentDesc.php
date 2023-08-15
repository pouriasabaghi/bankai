<?php

namespace App\Http\Livewire;

use App\Models\Installment;
use Livewire\Component;

class InstallmentDesc extends Component
{
    public $desc;
    public $installmentId ;

    public function mount($value){
        $this->desc = $value;
    }

    public function render()
    {
        return view('livewire.installment-desc');
    }


    public function syncDesc(){
        Installment::whereId($this->installmentId)->update([
            'desc' => $this->desc,
        ]);
    }
}
