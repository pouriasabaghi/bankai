<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use Livewire\Component;



class CustomerAndCompany extends Component
{

    public $firstTime = true;
    public $selectedCustomer;
    public $companies = [];
    public $customers = [];
    public function mount()
    {
        $this->customers = Customer::query()->latest()->get();
    }
    public function render()
    {
        return view('livewire.customer-and-company');
    }


    public function setSelectedCustomer($value)
    {
        // For hiding choice customer option in customers select option list
        $this->firstTime = false;
        $value = intval($value);
        if (boolval($value)) {
            $customer = Customer::find($value);
            $this->companies = $customer->companies;
        } else {
            $this->companies = [];
        }
        $this->dispatchBrowserEvent('enable-select2');
    }

}
