<?php

namespace App\Http\Livewire;

use App\Models\Company;
use App\Models\Contract;
use App\Models\Customer;
use App\Models\Installment;
use App\Models\Receive;
use App\Services\ContractService;
use App\Services\ReceiveService;
use Livewire\Component;

class Dashboard extends Component
{

    protected ContractService $contractService;
    protected Installment $installment;
    protected Receive $receive;
    protected ReceiveService $receiveService;
    protected Contract $contract;
    protected Customer $customer;
    protected Company $company;

    public $totalDebtor;
    public $customerCount;
    public $checks;
    public $balancePercent;
    public $balanceImprovement;
    public $contractsCount;
    public $companyCount;
    public $contractCanceledCount;

    public $contractToCall;
    public $contractNoNeedCall;


    protected $rules = [
        'contractToCall.*.draft' => 'string|min:6',
        'contractNoNeedCall.*.draft' => 'string|min:6',
    ];

    public function boot(){
        $this->contractService = new ContractService;
        $this->installment     = new Installment;
        $this->receive         = new Receive();
        $this->receiveService  = new ReceiveService;
        $this->contract        = new Contract;
        $this->customer        = new Customer;
        $this->company         = new Company;
    }


    public function mount()
    {

        $debtorContracts = $this->contract::whereHas('installments', function ($query) {
            $query->where('due_at', '<=', today())->where('status', 'billed')->where('collectible', true);
        })->get();

        // // contract with empty remind_at
        $this->contractToCall = $this->contract::whereHas('installments', function ($query) {
            $query->where('due_at', '<=', today())->where('status', 'billed')->where('collectible', true);
        })->whereNull('remind_at')->get();;

        // // // contract with value remind_at
        $this->contractNoNeedCall = $this->contract::whereHas('installments', function ($query) {
            $query->where('due_at', '<=', today())->where('status', 'billed')->where('collectible', true);
        })->whereNotNull('remind_at')->get();


        $this->totalDebtor = number_format($debtorContracts->sum(function ($contract) {
            return fix_number($this->receiveService->getDetail($contract)['debtor']);
        }));


        $this->checks = $this->receive->uncollectedChecks()->with('contract')->get();

        $balance                  = $this->contractService->getContractYearlyBalancePercent($this->contract);
        $this->balancePercent     = $balance['percent'];
        $this->balanceImprovement = $balance['improvement'];

        $this->contractsCount        = $this->contract::all()->count();
        $this->contractCanceledCount = $this->contract::where('contract_status', 'canceled')->get()->count();
        $this->customerCount         = $this->customer::all()->count();
        $this->companyCount          = $this->company::all()->count();
    }

    public function render()
    {

        return view('livewire.dashboard')->layout('admin.master');

    }

    public function toggleRemindAt($id, $type)
    {

        $this->contract::findOrFail($id)->update([
            'remind_at' => $type == 'add' ? now()->addDays(3) : null,
        ]);


        $debtorContracts = $this->contract::whereHas('installments', function ($query) {
            $query->where('due_at', '<=', today())->where('status', 'billed')->where('collectible', true);
        })->get();

        // contract with empty remind_at
        $this->contractToCall = $debtorContracts->whereNull('remind_at');



        // contract with value remind_at
        $this->contractNoNeedCall = $debtorContracts->whereNotNull('remind_at');
    }

    public function syncDraft(Contract $contract, $value){
        $contract->update([
            'draft' => $value,
        ]);
    }
}
