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
                    <x-ui.table.Table :attr="['id' => 'contracts-table']" :header="['#', 'نام‌قرارداد', 'مبلغ', 'تاریخ‌سررسید', 'قرارداد', 'اقساط', 'دریافتی‌ها']">
                        <x-slot name="tbody">
                            @forelse($debtorInstallments as $installment)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>
                                        {{ $installment->contract->name }}
                                    </td>
                                    <td>
                                        {{ $installment->amount_str }}
                                    </td>
                                    <td>
                                        {{ $installment->due_at }}
                                    </td>
                                    <td>
                                        <x-ui.button.Link class="ms-3"
                                            href="{{ route('contracts.create', $installment->contract->id) }}">
                                            مشاهده
                                        </x-ui.button.Link>
                                    </td>
                                    <td>
                                        <x-ui.button.Link class="ms-3"
                                            href="{{ route('installments.create', $installment->contract->id) }}">
                                            مشاهده
                                        </x-ui.button.Link>
                                    </td>
                                    <td>
                                        <x-ui.button.Link class="ms-3" href="{{ route('receives.create', $installment->contract->id) }}">
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
                </x-slot>
            </x-ui.card.Card>
        </div>
    </div>
@endsection
