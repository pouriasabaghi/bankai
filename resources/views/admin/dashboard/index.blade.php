@extends('admin.master')

@section('content')
    <x-dashboard.DashboardTitle>
        داشبورد
        <strong>مدیریت</strong>
    </x-dashboard.DashboardTitle>

    <div class="row">
        <div class="col-xxl-6">
            <x-ui.card.Card>
                <x-slot name='header'>
                    اقساط پرداخت نشده
                </x-slot>

                <x-slot name='body'>
                    @forelse($debtorInstallments as $date=>$installments)
                        <h5>
                            <i class="far fa-calendar"></i>
                            اقساط پرداخت نشده در تاریخ
                            {{ $date }}
                        </h5>
                        <x-ui.table.Table class="mb-5" :attr="['id' => 'contracts-table']" :header="['#', 'نام‌قرارداد', 'مبلغ', 'تماس', 'دریافتی‌ها']">
                            <x-slot name="tbody">
                                @forelse($installments as $installment)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>
                                            {{ $installment->contract->name }}
                                        </td>
                                        <td>
                                            {{ $installment->amount_str }}
                                        </td>
                                        <td>
                                            {{ $installment->contract->customer->mobile }}
                                        </td>
                                        <td>
                                            <x-ui.button.Link class="ms-3"
                                                href="{{ route('receives.create', $installment->contract->id) }}">
                                                مشاهده
                                            </x-ui.button.Link>
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
                    @empty
                        <h5>قسط پرداخت نشده‌ای یافت نشد</h5>
                    @endforelse
                </x-slot>
            </x-ui.card.Card>
        </div>
    </div>
@endsection
