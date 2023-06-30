@extends('admin.master')

@section('content')

    <x-ui.card.Card>
        <x-slot name='header'>
            چک‌ها
        </x-slot>

        <x-slot name='body'>
            @forelse($checks as $date=>$dateChecks)
                <h5>
                    <i class="far fa-calendar"></i>
                    چک‌های تاریخ
                    {{ $date }}
                </h5>
                <x-ui.table.Table class="mb-5" :attr="['id' => 'contracts-table']" :header="['نام‌قرارداد', 'بانک', 'شعبه', 'کدشعبه', 'سریال‌جک', 'توضیحات', 'اقدامات']">
                    <x-slot name="tbody">
                        @foreach ($dateChecks as $check)

                            <tr >
                                <td>
                                    {{ $check->contract->name }}
                                </td>
                                <td>
                                    {{ $check->bank_name }}
                                </td>
                                <td>
                                    {{ $check->branch_name }}
                                </td>
                                <td>
                                    {{ $check->branch_code }}
                                </td>
                                <td>
                                    {{ $check->serial_number }}
                                </td>
                                <td>
                                    {{ $check->desc }}
                                </td>
                                <td class=" {{ \App\Enums\ReceiveStatusEnum::tryFrom($check->passed)->statusColor() }}">
                                    <x-ui.button.Link class="ms-3"
                                        href="{{ route('receives.create', $check->contract->id) }}#receive-{{ $check->id }}">
                                        مشاهده
                                    </x-ui.button.Link>
                                </td>
                            </tr>
                        @endforeach
                    </x-slot>
                </x-ui.table.Table>
            @empty
                <h5>چک یافت نشد</h5>
            @endforelse
        </x-slot>
    </x-ui.card.Card>


@endsection
