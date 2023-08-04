@extends('admin.master')

@section('content')
    <x-ui.card.Card id='receives'>
        <x-slot name='header'>
            <i class="fa-solid fa-sack-dollar"></i>
            <span>وصولی‌ها</span>
            <span>{{ $periodTitle }}</span>
        </x-slot>
        <x-slot name='body'>
            <x-ui.table.Table :header="['#', 'عنوان', 'مدیریت', 'مبلغ', 'تاریخ واریز', 'حساب‌مقصد', 'نوع‌پرداخت', 'توضیحات']">
                <x-slot name="tbody">
                    @foreach ($data as $receive)
                        <tr>
                            <td>
                                <span>{{ $loop->index + 1 }}</span>
                            </td>
                            <td>
                                <span>{{ $receive->contract->name }}</span>
                            </td>
                            <td>
                                <span>{{ $receive->contract->customer->name }}</span>
                            </td>
                            <td>
                                @if ($receive->contract->exists)
                                    <a href="{{ route('receives.create', $receive->contract->id) }}#receive-{{ $receive->id }}">{{ $receive->amount_str }}</a>
                                @else
                                    <span class="text-muted">{{ $receive->amount_str }}</span>
                                @endif
                            </td>
                            <td>
                                <span>{{ $receive->date }}</span>
                            </td>
                            <td>
                                <span>{{ $receive->card->name }}</span>
                            </td>
                            <td>
                                <span>{{ $receive->type_str }}</span>
                            </td>
                            <td>
                                {{ $receive->desc }}
                            </td>
                        </tr>
                    @endforeach
                </x-slot>
            </x-ui.table.Table>
        </x-slot>
    </x-ui.card.Card>
@endsection
