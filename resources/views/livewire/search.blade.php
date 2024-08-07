<div class="search px-2">
    <x-ui.form.Input livewire="wire:model=search " placeholder="جستجو" class="form-control" placeholder='جستجو...' />
    <x-ui.loader.Loader livewire="wire:loading.flex" />
    @if ($search)
        <div class="search__result shadow-sm rounded">
            @forelse ($searchResult as $result)
                <ol class="list-group ">
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <a title="مشاهده قرارداد" href="{{ route('contracts.edit', $result->id) }}"
                                class="d-block fw-bold">{{ $result->name }}</a>
                            @if (!empty($result->customer->id))
                                <a title="مشاهده مشتری"
                                    href="{{ route('details.list', ['type' => 'customer', 'id' => $result->customer->id, 'directory' => 'customers']) }}">
                                    {{ $result->customer->name }}
                                </a>
                            @endif
                        </div>
                        @if ($result->contract_status === 'canceled')
                            <span class="badge bg-danger rounded-pill">کنسل شده</span>
                        @endif

                        @if ($result->archived)
                            <span class="badge bg-secondary rounded-pill">آرشیو</span>
                        @endif
                    </li>
                </ol>
            @empty
                <ol class="list-group ">
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <span class="fw-bold">نتیجه‌ای یافت نشد!</س>
                        </div>
                    </li>
                </ol>
            @endforelse
        </div>
    @endif
</div>
