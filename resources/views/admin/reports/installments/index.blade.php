@extends('admin.master')

@section('content')
    <x-ui.card.Card id='receives'>
        <x-slot name='header'>
            <i class="fa-solid fa-sack-dollar"></i>
            <span>مطالبات</span>
            <span>{{ $periodTitle }}</span>
        </x-slot>
        <x-slot name='body'>
            @include('admin.reports.layouts.sum', [
                'total' => number_format($total),
                'text' => 'جمع کل مطالبات',
            ])
            <x-ui.table.Table :header="['#', 'عنوان', 'مدیریت', 'مبلغ', 'تاریخ واریز', 'نوع‌پرداخت', 'توضیحات']">
                <x-slot name="tbody">
                    @foreach ($data as $installment)
                        <tr>
                            <td>
                                <span>{{ $loop->index + 1 }}</span>
                            </td>
                            <td>
                                @if ($installment->contract->id)
                                    <a href="{{ route('contracts.edit', $installment->contract->id) }}">
                                        {{ $installment->contract->name }}
                                    </a>
                                @else
                                    {{ $installment->contract->name }}
                                @endif
                            </td>
                            <td>
                                @if ($installment->contract->customer->id)
                                    <a
                                        href="{{ route('details.list', ['type' => 'customer', 'id' => $installment->contract->customer->id, 'directory' => 'customers']) }}">
                                        {{ $installment->contract->customer->name }}
                                    </a>
                                @else
                                    <span> {{ $installment->contract->customer->name }}</span>
                                @endif
                            </td>
                            <td>
                                @if ($installment->contract->exists)
                                    <a
                                        href="{{ route('installments.create', $installment->contract->id) }}">{{ $installment->amount_str }}</a>
                                @else
                                    <span class="text-muted">{{ $installment->amount_str }}</span>
                                @endif

                            </td>
                            <td>
                                <span>{{ $installment->due_at }}</span>
                            </td>
                            <td>
                                <span>
                                    {{ \App\Enums\InstallmentKindEnum::tryFrom($installment->kind)->toString() }}
                                </span>
                            </td>
                            <td>
                                <span>{{ $installment->desc }}</span>
                            </td>
                        </tr>
                    @endforeach
                </x-slot>
            </x-ui.table.Table>
            <x-ui.paginate.Paginate class="mt-3 px-3" :paginate="$data" />
        </x-slot>
    </x-ui.card.Card>
@endsection
