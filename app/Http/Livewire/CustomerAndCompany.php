<?php

namespace App\Http\Livewire;

use App\Models\Company;
use App\Models\Contract;
use App\Models\Customer;
use Livewire\Component;



class CustomerAndCompany extends Component
{

    public $firstTime = true;
    public $selectedCustomer;
    public $selectedCompany;
    public $customers;
    public $companies = [];
    public $contractCustomerId;
    public $contractCompanyId ;
    public $companyIsValid ;
    public function mount()
    {
        // in update form set previous value of customer_id
        if ($customerId = $this->contractCustomerId) {
            $this->selectedCustomer =  $customerId ;
        }

        // in update form set previous value of company_id
        $companyId = $this->contractCompanyId;
        if ($companyId) {
            $company = Company::query()->firstWhere('id', $companyId);
            if ($company) {
                $this->companyIsValid = true ;
                $this->selectedCompany =  $companyId ;
            }else{
                $this->companyIsValid = false ;
            }
        }

        if ($this->selectedCustomer) {
            $this->companies  = Customer::query()->firstWhere('id', $this->selectedCustomer)->companies ;
        }
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
