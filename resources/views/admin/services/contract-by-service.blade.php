@extends('admin.master')



@section('content')
    @include('admin.layouts.template.page-settings')
    <x-ui.card.Card>
        <x-slot name='header'>
            <span data-feather="file-text"></span>
            <span>لیست قراردادهای
                {{ $service->name }}
            </span>
        </x-slot>

        <x-slot name='body'>
            <x-ui.button.Button href="{{ route('services.index') }}" btn="secondary" class="mb-3">بازگشت به خدمات</x-ui.button.Button>
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
            ]">
                <x-slot name="tbody">
                    @forelse($contracts as $contract)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>
                                <a href="{{ route('contracts.edit', $contract->id) }}">
                                    {{ $contract->name }} / {{ $contract->company->name }}
                                </a>
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
                            {{ $contract->expired_at }}
                        </td>
                        <td>
                            {{ $contract->total_price_str }}
                        </td>
                        <td>
                            {{ number_format($contract->totalReceives) }}
                        </td>
                        <td>
                            {{ $receiveService->getDetail($contract)['rest'] }}
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
                    </tr>
                @empty
                    <tr>
                        @foreach (range(1, 10) as $item)
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
