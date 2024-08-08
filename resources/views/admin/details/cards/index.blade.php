@extends('admin.master')



@section('content')
    <x-ui.card.Card>
        <x-slot name='header'>
            <span data-feather="credit-card"></span>
            <span>ورود و خروج حساب</span>
            <span>{{ $cardName }}</span>
        </x-slot>

        <x-slot name='body'>
            <x-ui.table.Table :header="['#', 'عنوان', 'مبلغ', 'تاریخ', 'حساب مبدا', 'حساب‌مقصد', 'نوع‌پرداخت', 'توضیحات']">
                <x-slot name="tbody">
                    @foreach ($data as $transaction)
                        <tr >
                            <td>
                                <span>{{ $loop->index + 1 }}</span>
                            </td>
                            <td>
                                <span>{{ $transaction['contract']->name}}</span>
                            </td>
                            <td class="text-white {{ $transaction['isReceive'] ? 'bg-success' : 'bg-danger' }}" >
                                <span>{{ $transaction['amount_str'] }}</span>
                            </td>
                            {{-- <td>
                                @if (!empty($transaction->contract->exists))
                                    <a href="{{ route('receives.create', $transaction->contract->id) }}#receive-{{ $transaction->id }}">{{ $transaction->amount_str }}</a>
                                @else
                                    <span class="text-muted">{{ $transaction->amount_str }}</span>
                                @endif
                            </td> --}}
                            <td>
                                <span>{{ $transaction['date'] }}</span>
                            </td>
                            <td>
                                <span>{{ $transaction['from'] }}</span>
                            </td>
                            <td>
                                <span>{{ $transaction['to'] }}</span>
                            </td>
                            <td>
                                <span>{{ $transaction['type'] }}</span>
                            </td>
                            <td>
                                {{ $transaction['desc'] }}
                            </td>
                        </tr>
                    @endforeach
                </x-slot>
            </x-ui.table.Table>

            <x-ui.paginate.Paginate class="mt-3 px-3" :paginate="$data" />
        </x-slot>
    </x-ui.card.Card>
@endsection
