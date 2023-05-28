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
            <x-ui.table.Table :attr="['id' => 'contracts-table']" :header="['#', 'نام', 'اقساط', 'دریافتی‌ها', 'اقدامات']">
                <x-slot name="tbody">
                    @forelse($contracts as $contract)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>
                                {{ $contract->name }}
                            </td>
                            <td>
                                <x-ui.button.Link class="ms-3" href="{{ route('installments.create', $contract->id) }}">
                                    مشاهده
                                    {{-- <i class="fa-regular fa-calendar-check fa-xl"></i> --}}
                                </x-ui.button.Link>
                            </td>
                            <td>
                                <x-ui.button.Link class="ms-3" href="{{ route('receives.create', $contract->id) }}">
                                    {{-- <i class="fa-solid fa-money-check-dollar fa-xl"></i> --}}
                                    مشاهده
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
