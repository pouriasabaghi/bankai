@extends('admin.master')

@section('content')
    <x-ui.card.Card id='receives'>
        <x-slot name='header'>
            <i class="fa-solid fa-sack-dollar"></i>
            <span>وصولی‌ها</span>
            <span>{{ $periodTitle }}</span>
        </x-slot>
        <x-slot name='body'>
            @include('admin.reports.layouts.sum', [
                'total' => number_format($total),
                'text' => 'جمع کل وصولی‌ها',
            ])

            @include('admin.reports.layouts.cards-sum-detail', compact('cards', 'periodTitle'))


            <x-ui.table.Table :header="['#', 'عنوان', 'مدیریت', 'مبلغ', 'تاریخ واریز', 'حساب‌مقصد', 'نوع‌پرداخت', 'توضیحات']">
                <x-slot name="tbody">
                    @foreach ($data as $receive)
                        <tr>
                            <td>
                                <span>{{ $loop->index + 1 }}</span>
                            </td>
                            <td>
                                @if ($receive->contract->id)
                                    <a href="{{ route('contracts.edit', $receive->contract->id) }}">
                                        {{ $receive->contract->name }}
                                    </a>
                                @else
                                    {{ $receive->contract->name }}
                                @endif
                            </td>
                            <td>
                                @if ($receive->contract->customer->id)
                                    <a
                                        href="{{ route('details.list', ['type' => 'customer', 'id' => $receive->contract->customer->id, 'directory' => 'customers']) }}">
                                        {{ $receive->contract->customer->name }}
                                    </a>
                                @else
                                    <span> {{ $receive->contract->customer->name }}</span>
                                @endif
                            </td>
                            <td>
                                @if ($receive->contract->exists)
                                    <a
                                        href="{{ route('receives.create', $receive->contract->id) }}#receive-{{ $receive->id }}">{{ $receive->amount_str }}</a>
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
                                {{ $receive->desc ?? $receive->origin }}
                            </td>
                        </tr>
                    @endforeach
                </x-slot>
            </x-ui.table.Table>
            <x-ui.paginate.Paginate class="mt-3 px-3" :paginate="$data" />
        </x-slot>
    </x-ui.card.Card>
@endsection
