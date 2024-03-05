@extends('admin.master')



@section('content')
    <x-ui.card.Card>
        <x-slot name='header'>
            <span data-feather="users"></span>
            <span>مشتریان</span>
        </x-slot>

        <x-slot name='body'>
            @if (auth()->user()->role != 'user')
                <x-ui.button.Button href="{{ route('customers.create') }}" btn='success' class="mb-3">افزودن مشتری
                    جدید</x-ui.button.Button>
            @endif

            <x-ui.table.Table :attr="['id' => 'customers-table']" :header="['#', 'نام', 'موبایل', 'تلفن', 'اقدامات']">
                <x-slot name="tbody">
                    @forelse($customers as $customer)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>
                                <a
                                    href="{{ route('details.list', ['type' => 'customer', 'id' => $customer->id, 'directory' => 'customers']) }}">
                                    {{ $customer->name }}
                                </a>
                            </td>
                            <td>{{ $customer->mobile }}</td>
                            <td>{{ $customer->phone }}</td>
                            <td>
                                <div class="d-flex">
                                    @if (auth()->user()->role != 'user')
                                        <form method="post" action='{{ route('customers.destroy', $customer->id) }}'>
                                            @csrf
                                            @method('DELETE')
                                            <x-ui.button.Delete />
                                        </form>
                                    @endif

                                    <x-ui.button.Edit href="{{ route('customers.edit', $customer->id) }}" />
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

            <x-ui.paginate.Paginate class="mt-3 px-3" :paginate="$customers" />
        </x-slot>
    </x-ui.card.Card>
@endsection
