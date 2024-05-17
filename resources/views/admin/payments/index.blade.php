@extends('admin.master')



@section('content')
    <x-ui.card.Card>
        <x-slot name='header'>
            <span data-feather="dollar-sign"></span>
            <span>پرداخت‌ها</span>
        </x-slot>

        <x-slot name='body'>
            <x-ui.button.Button href="{{ route('payments.create') }}" btn='success' class="mb-3">افزودن پرداخت جدید
            </x-ui.button.Button>
            <x-ui.table.Table :attr="['id' => 'payments-table']" :header="['#', 'ازحساب', 'به‌حساب', 'مبلغ', 'بابت', 'اقدامات']">
                <x-slot name="tbody">
                    @forelse($payments as $payment)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>
                                <a href="#">
                                    {{ $payment->fromCard->name }}
                                </a>
                            </td>
                            <td>{{ $payment->to }}</td>
                            <td>{{ $payment->amountStr }}</td>
                            <td>{{ $payment->cost->name ?? $payment }}</td>
                            <td>
                                <div class="d-flex">
                                    <form method="post" action='{{ route('payments.destroy', $payment->id) }}'>
                                        @csrf
                                        @method('DELETE')
                                        <x-ui.button.Delete />
                                    </form>

                                    <x-ui.button.Edit href="{{ route('payments.edit', $payment->id) }}" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            @foreach (range(1, 6) as $item)
                                <td>-</td>
                            @endforeach
                        </tr>
                    @endforelse
                </x-slot>
            </x-ui.table.Table>

            <x-ui.paginate.Paginate class="mt-3 px-3" :paginate="$payments" />
        </x-slot>
    </x-ui.card.Card>
@endsection
