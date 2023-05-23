<?php

namespace App\Http\Livewire;

use App\Models\Service;
use Livewire\Component;

class SelectOrCreateService extends Component
{
    public $services;
    public $service_name;
    protected  $serviceObj;
    public $servicesList = [];
    // previous value of services in edit form
    public $selectedServices;
    private $select2EventName = 'enable-select2-services';
    public function mount()
    {
        $this->services = Service::query()->latest()->get() ??  collect([]);

        if (!empty($this->selectedServices)) {
            $this->servicesList = $this->selectedServices;
        }
    }

    public function render()
    {
        return view('livewire.select-or-create-service');
    }

    public function updatedServiceName()
    {

        $this->dispatchBrowserEvent($this->select2EventName);
    }

    public function store()
    {
        $this->service_name =  trim($this->service_name);
        if (empty($this->service_name)) {
            session()->flash('message', 'عنوان نمی‌تواند خالی باشد');
            $this->dispatchBrowserEvent($this->select2EventName);
            return;
        }

        // prevent to make multiple instance of service
        if (!$this->serviceObj) {
            $this->serviceObj = new Service();
        }

        // create service
        $newService = $this->serviceObj->create([
            'name' => $this->service_name,
        ]);

        // push new service to previous services
        $this->services->push($newService);

        // push new service to serviceList as selected
        $this->servicesList[] = $newService->id;
        // empty input
        $this->service_name = '';

        // add new service to pervious services
        $this->dispatchBrowserEvent($this->select2EventName);
    }

    public function keepSelectedServiceUpdate($value)
    {
        $this->servicesList = $value;
        $this->dispatchBrowserEvent($this->select2EventName);
    }
}
