@extends('admin.master')

@section('content')
    <x-dashboard.DashboardTitle>
        داشبورد
        <strong>مدیریت</strong>
    </x-dashboard.DashboardTitle>

    <div class="row">
        <div class="col-xl-6" id="dashbaord-installments">
            <x-ui.card.Card>
                <x-slot name='header'>
                    اقساط پرداخت نشده
                </x-slot>

                <x-slot name='body'>
                    <div class="dashbaord-installments__group">
                        @forelse($debtorInstallments as $contractId => $installments)
                            @php
                                $contract = App\Models\Contract::where('id', $contractId)->first();
                            @endphp
                            <div class="d-inline-block w-100">
                                <x-ui.collapse.Collapse parent='dashbaord-installments'
                                    parentClass="mb-5 bg-light shadow-lg p-4" id="contract-{{ $contractId }}">
                                    <div>
                                        <p>
                                            <i class="far fa-file-contract"></i>
                                            قرارداد:
                                            <span class="fw-bold">{{ $contract->name }}</span>
                                        </p>
                                    </div>
                                    <div>
                                        <p>
                                            <i class="far fa-hotel"></i>
                                            مجموعه:
                                            <span class="fw-bold">{{ $contract->company->name }}</span>
                                        </p>
                                    </div>
                                    <div>
                                        <p>
                                            <i class="far fa-user"></i>
                                            مشتری:
                                            <span class="fw-bold">{{ $contract->customer->name }}</span>
                                        </p>
                                    </div>
                                    <div>
                                        <p>
                                            <i class="far fa-mobile-screen-button"></i>
                                            موبایل:
                                            <span class="fw-bold">{{ $contract->customer->mobile }}</span>
                                        </p>
                                    </div>
                                    <div>
                                        تعداد
                                        <span class="fw-bold">{{ $installments->count() }}</span>
                                        قسط جمعا به مبلغ
                                        <span class="fw-bold">{{ number_format($installments->sum('amount')) }}</span>
                                        <small>تومان</small>
                                    </div>

                                    <div role="button" class="mt-3 btn btn-sm btn-outline-secondary rounded">
                                        جزئیات
                                        <i class="far fa-angle-down"></i>
                                    </div>

                                    <x-slot name='content'>
                                        <a class="mt-3 mb-1 d-block" href="{{ route('receives.create', $contractId) }}">
                                            رفتن به دریافتی‌ها
                                        </a>
                                        <x-ui.table.Table selector='#contracts-table' class="right-side" :attr="['id' => 'contracts-table']" :header="['مبلغ', 'تاریخ', 'توضیحات']">
                                            <x-slot name="tbody">
                                                @forelse($installments as $installment)
                                                    <tr>
                                                        <td>
                                                            <span class="badge bg-warning">
                                                                {{ \App\Enums\InstallmentKindEnum::tryFrom($installment->kind)->toString() }}
                                                            </span>
                                                            {{ $installment->amount_str }}</td>
                                                        <td>
                                                            {{ $installment->due_at }}
                                                        </td>
                                                        <td>
                                                            <x-ui.form.Input  type="text" value="{{ $installment->desc  }}" />
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
                            </div>
                        @empty
                            <h5>قسط پرداخت نشده‌ای یافت نشد</h5>
                        @endforelse
                    </div>
                </x-slot>
            </x-ui.card.Card>
        </div>

        <div class="col-xl-6">
            <x-ui.card.Card>
                <x-slot name='header'>
                    چک‌های در انتظار وصول
                </x-slot>

                <x-slot name='body'>
                    @forelse($uncollectedChecks as $date=>$checks)
                        <h5>
                            <i class="far fa-calendar"></i>
                            چک‌های تاریخ
                            {{ $date }}
                        </h5>
                        <x-ui.table.Table class="mb-5" :attr="['id' => 'contracts-table']" :header="['نام‌قرارداد', 'مبلغ', 'تماس', 'جزئیات']">
                            <x-slot name="tbody">
                                @foreach ($checks as $check)
                                    <tr>
                                        <td>
                                            {{ $check->contract->name }}
                                        </td>
                                        <td>
                                            {{ $check->amount_str }}
                                        </td>
                                        <td>
                                            {{ $check->contract->customer->mobile }}
                                        </td>
                                        <td>
                                            @if (filled($check->contract->id))
                                                <x-ui.button.Link class="ms-3"
                                                    href="{{ route('receives.create', $check->contract->id) }}#receive-{{ $check->id }}">
                                                    مشاهده
                                                </x-ui.button.Link>
                                            @else
                                                <x-ui.button.Link class="ms-3 text-muted" href="#">
                                                    مشاهده
                                                </x-ui.button.Link>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </x-slot>
                        </x-ui.table.Table>
                    @empty
                        <h5>چک در انتظار وصول یافت نشد</h5>
                    @endforelse
                </x-slot>
            </x-ui.card.Card>
        </div>
    </div>
@endsection
