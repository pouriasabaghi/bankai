@extends('admin.master')



@section('content')
    @include('admin.layouts.template.page-settings')
    <x-ui.card.Card>
        <x-slot name='header'>
            <span data-feather="umbrella"></span>
            <span>مجموعه ها</span>
        </x-slot>
        <x-slot name='subtitle'>
            لیست بنگاه‌ها و مجموعه‌های مشتریان
        </x-slot>
        <x-slot name='body'>
            @if (auth()->user()->role != 'user')
                <x-ui.button.Button href="{{ route('companies.create') }}" btn='success' class="mb-3">افزودن مجموعه
                    جدید</x-ui.button.Button>
            @endif
            <x-ui.table.Table :attr="['id' => 'companies-table']" :header="['#', 'نام', 'صاحب(های)مجموعه', 'اقدامات']">
                <x-slot name="tbody">
                    @forelse($companies as $company)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>
                                <a href="">
                                    {{ $company->name }}
                                </a>
                            </td>
                            <td>{{ $company->customers_str }}</td>
                            <td>
                                <div class="d-flex">
                                    @if (auth()->user()->role != 'user')
                                        <form method="post" action='{{ route('companies.destroy', $company->id) }}'>
                                            @csrf
                                            @method('DELETE')
                                            <x-ui.button.Delete />
                                        </form>
                                    @endif
                                    <x-ui.button.Edit href="{{ route('companies.edit', $company->id) }}" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            @foreach (range(1, 4) as $item)
                                <td>-</td>
                            @endforeach
                        </tr>
                    @endforelse
                </x-slot>
            </x-ui.table.Table>

            <x-ui.paginate.Paginate class="mt-3 px-3" :paginate="$companies" />
        </x-slot>
    </x-ui.card.Card>
@endsection
