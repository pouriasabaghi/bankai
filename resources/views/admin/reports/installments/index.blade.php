@extends('admin.master')

@section('content')
    <x-ui.card.Card id='receives'>
        <x-slot name='header'>
            <i class="fa-solid fa-sack-dollar"></i>
            <span>مطالبات</span>
            <span>{{ $periodTitle }}</span>
        </x-slot>
        <x-slot name='body'>
            <x-ui.table.Table :header="['#', 'عنوان', 'مدیریت', 'مبلغ', 'تاریخ واریز', 'نوع‌پرداخت', 'توضیحات']">
                <x-slot name="tbody">
                    @foreach ($data as $installment)
                        <tr>
                            <td>
                                <span>{{ $loop->index + 1 }}</span>
                            </td>
                            <td>
                                <span>{{ $installment->contract->name }}</span>
                            </td>
                            <td>
                                <span>{{ $installment->contract->customer->name }}</span>
                            </td>
                            <td>
                                <span>{{ $installment->amount_str }}</span>
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
