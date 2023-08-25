<x-ui.card.Card class="dashboard-cards shadow-lg ">
    <x-slot name='header'>
        @if ($type == 'add')
            اولویت‌ها
        @else
            انتظار بررسی
        @endif

    </x-slot>

    <x-slot name='body'>
        <div class="dashbaord-installments__group">
            @forelse($contracts as $contract)
                <div class="d-inline-block w-100 bg-light shadow-lg p-4 mb-5 ">
                    <div class="text-end">
                        @if ($type == 'add')
                            <button class="btn btn-sm btn-outline-info"
                                wire:click='toggleRemindAt({{ $contract->id }}, {{ "'$type'" }})'>
                                افزودن به در انتظار بررسی
                            </button>
                        @else
                            <button class="btn btn-sm btn-primary"
                                wire:click='toggleRemindAt({{ $contract->id }}, {{ "'$type'" }})'>
                                افزودن به اولویت‌ها
                            </button>
                        @endif
                    </div>
                    @include('admin.dashboard.layouts.installment-details')

                    {{-- Calls --}}
                    <x-ui.collapse.Collapse parent='dashbaord-installments' id="contract-calls-{{ $contract->id }}">
                        <div role="button" class="mt-3 btn btn-sm btn-outline-secondary rounded">
                            جزئیات
                            <i class="far fa-angle-down"></i>
                            <br>
                        </div>

                        <x-slot name='content'>
                            <a class="mt-3 mb-1 d-block" href="{{ route('receives.create', $contract->id) }}">
                                رفتن به دریافتی‌ها
                            </a>
                            <x-ui.table.Table selector='#contracts-table' class="right-side" :attr="['id' => 'contracts-table']"
                                :header="['مبلغ', 'تاریخ', 'توضیحات']">
                                <x-slot name="tbody">
                                    @forelse($contract->debtorInstallments()->get() as $installment)
                                        <tr>
                                            <td>
                                                {{ $installment->amount_str }}
                                                <span class="badge bg-warning">
                                                    {{ \App\Enums\InstallmentKindEnum::tryFrom($installment->kind)->toString() }}
                                                </span>
                                            </td>
                                            <td>
                                                {{ $installment->due_at }}
                                            </td>
                                            <td class="position-relative">
                                                {{-- <x-ui.form.Input  type="text" value="{{ $installment->desc  }}" /> --}}

                                                <livewire:installment-desc installmentId="{{ $installment->id }}"
                                                    value="{{ $installment->desc }}" :wire:key="$installment->id" />
                                            </td>

                                        </tr>
                                    @empty
                                        <tr>
                                            @foreach (range(1, 7) as $item)
                                                <td>-</td>
                                            @endforeach
                                        </tr>
                                    @endforelse
                                </x-slot>
                            </x-ui.table.Table>
                        </x-slot>
                    </x-ui.collapse.Collapse>

                    {{-- Drafts --}}
                    <x-ui.collapse.Collapse parent='dashbaord-installments' id="contract-drafts-{{ $contract->id }}">
                        <div role="button" class="mt-3 btn btn-sm btn-outline-secondary rounded">
                            توضیحات تکمیلی
                            <i class="far fa-angle-down"></i>
                            <br>
                        </div>

                        <x-slot name='content'>
                            @if ($type == 'add')
                                <textarea wire:key="contract-draft-{{ $contract->id }}" data-v="{{ $contract->draft }}"
                                    wire:model.lazy="contractToCall.{{ $loop->index }}.draft" wire:change="syncDraft({{ $contract->id }}, $event.target.value)"
                                    class="form-control mb-0 mt-2"></textarea>
                            @else
                                <textarea wire:key="contract-draft-{{ $contract->id }}" data-v="{{ $contract->draft }}"
                                    wire:model.lazy="contractNoNeedCall.{{ $loop->index }}.draft" wire:change="syncDraft({{ $contract->id }}, $event.target.value)"
                                    class="form-control mb-0 mt-2"></textarea>
                            @endif

                        </x-slot>
                    </x-ui.collapse.Collapse>

                </div>
            @empty
                <h5>موردی یافت نشد.</h5>
            @endforelse
        </div>

    </x-slot>
</x-ui.card.Card>
