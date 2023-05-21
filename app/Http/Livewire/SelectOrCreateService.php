<?php

namespace App\Http\Livewire;

use App\Models\Service;
use Livewire\Component;

class SelectOrCreateService extends Component
{
    public $services;
    public $service_name;
    protected  $serviceObj;
    public function mount()
    {
        $this->services = Service::query()->latest()->get() ??  collect([]);
    }

    public function render()
    {
        return view('livewire.select-or-create-service');
    }

    public function updatedServiceName($value)
    {
        $this->service_name =  trim($value);
        $this->dispatchBrowserEvent('enable-select2');
    }

    public function store()
    {

        if (empty($this->service_name)) {
            session()->flash('message', 'عنوان نمی‌تواند خالی باشد');
            $this->dispatchBrowserEvent('enable-select2');
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

        // empty input
        $this->service_name = '';

        // add new service to pervious services
        $this->dispatchBrowserEvent('enable-select2', ['id' => $newService->id]);
    }
}
