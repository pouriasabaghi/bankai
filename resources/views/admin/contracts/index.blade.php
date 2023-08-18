@extends('admin.master')



@section('content')
    <x-ui.card.Card>
        <x-slot name='header'>
            <span data-feather="file-text"></span>
            <span>مدیریت قراردادها</span>
        </x-slot>

        <x-slot name='body'>
            <x-ui.button.Button href="{{ route('contracts.create') }}" btn='success' class="mb-3">افزودن قرارداد جدید
            </x-ui.button.Button>
            <x-ui.table.Table :attr="['id' => 'contracts-table']" :header="[
                '#',
                'عنوان‌قرارداد',
                'نام‌مشتری',
                'تاریخ‌شروع',
                'تاریخ‌پایان',
                'مبلغ‌قرارداد',
                'دریافتی',
                'مانده',
                'اقساط / دریافتی‌ها',
                'اقدامات',
            ]">
                <x-slot name="tbody">
                    @forelse($contracts as $contract)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>
                                {{ $contract->name }} / {{ $contract->company->name }}
                            </td>
                            <td>
                            @empty($contract->customer->id)
                                {{ $contract->customer->name }}
                            @else
                                <a
                                    href="{{ route('details.list', ['type' => 'customer', 'id' => $contract->customer->id, 'directory' => 'customers']) }}">
                                    {{ $contract->customer->name }}
                                </a>
                            @endempty
                        </td>

                        <td>
                            {{ $contract->started_at }}
                        </td>
                        <td>
                            {{ jdate()->fromFormat('Y/m/d', $contract->started_at)->addMonths(intVal($contract->period))->format('Y/m/d') }}
                        </td>
                        <td>
                            {{ $contract->total_price_str }}
                        </td>
                        <td>
                            {{ number_format($contract->totalReceives) }}
                        </td>
                        <td>
                            {{ number_format($contract->totalRest) }}
                        </td>
                        <td>
                            <x-ui.button.Link class="ms-3" href="{{ route('installments.create', $contract->id) }}">
                                <span title="مشاهده اقساط">
                                    <span class="text-warning" data-feather="calendar"></span>
                                </span>
                            </x-ui.button.Link>
                            <span class="ms-3">/</span>
                            <x-ui.button.Link class="ms-3" href="{{ route('receives.create', $contract->id) }}">
                                <span title="مشاهده دریافتی‌ها">
                                    <span class="text-success " data-feather="dollar-sign"></span>
                                </span>
                            </x-ui.button.Link>
                        </td>
                        <td>
                            <div class="d-flex">
                                <form method="post" action='{{ route('contracts.destroy', $contract->id) }}'>
                                    @csrf
                                    @method('DELETE')
                                    <x-ui.button.Delete />
                                </form>

                                <x-ui.button.Edit href="{{ route('contracts.edit', $contract->id) }}" />

                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        @foreach (range(1, 5) as $item)
                            <td>-</td>
                        @endforeach
                    </tr>
                @endforelse
            </x-slot>
        </x-ui.table.Table>

        <x-ui.paginate.Paginate class="mt-3 px-3" :paginate="$contracts" />
    </x-slot>
</x-ui.card.Card>
@endsection
