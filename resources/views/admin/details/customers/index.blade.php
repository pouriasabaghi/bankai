@extends('admin.master')



@section('content')
    <x-ui.card.Card>
        <x-slot name='header'>
            <span data-feather="credit-card"></span>
            <span>قرارداد</span>
        </x-slot>

        <x-slot name='body'>
            <div class="row">
                <div class="col-xl-4">
                    <x-ui.card.Card>
                        <x-slot name='header'>

                            <h5 class="card-title mb-0">{{ $customer->name }}</h5>
                        </x-slot>
                        <x-slot name='body'>
                            <div class="row g-0">
                                <div class="col-sm-3 col-xl-12 col-xxl-3 text-center">
                                    <i class="fa-solid fa-3x fa-circle-user bg-light"></i>
                                </div>
                                <div class="col-sm-9 col-xl-12 col-xxl-9">
                                    <strong>توضیحات</strong>
                                    <p>{{ $customer->desc ?? '...' }}</p>
                                </div>
                            </div>

                            <table class="table no-default-table vtable-sm mt-2 mb-4">
                                <tbody>
                                    <tr>
                                        <th class="text-dark">نام</th>
                                        <td>{{ $customer->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>مجموعه‌ها</th>
                                        <td>{{ $companies }}</td>
                                    </tr>
                                    <tr>
                                        <th>موبایل‌ها</th>
                                        <td>{{ $customer->mobile }}</td>
                                    </tr>
                                    <tr>
                                        <th>تعداد‌ قرارداد‌ها</th>
                                        <td>{{ $contracts->count() }}</td>
                                    </tr>

                                    <tr>
                                        <th>بدهکار تا به الان</th>
                                        <td>
                                            {{ number_format($totalDebtor) }}
                                            <small>تومان</small>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <strong>آخرین واریزی‌ها</strong>
                            <ul class="timeline mt-2 mb-0">
                                @forelse ($receives as $receive)
                                    <li class="timeline-item">
                                        <strong>{{ $receive->type == 'deposit' ? 'واریز' : 'چک' }}</strong>
                                        <span
                                            class="float-start text-muted text-sm">{{ jdate()->fromFormat('Y/m/d', $receive->paid_at ?? $receive->due_at)->toCarbon()->ago() }}</span>
                                        <p>
                                            {{ $receive->contract->name }}
                                            <br>
                                            {{ $receive->desc ?? $receive->origin }}
                                        </p>

                                    </li>
                                @empty
                                    <li class="timeline-item">
                                        <strong>-</strong>
                                        <span class="float-start text-muted text-sm">0</span>
                                        <p>...</p>
                                    </li>
                                @endforelse

                            </ul>

                        </x-slot>
                    </x-ui.card.Card>
                </div>

                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h5 class="card-title mb-0">قراردادها</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-responsive table-striped no-default-table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>عنوان قرارداد</th>
                                        <th>اقساط‌مانده</th>
                                        <th>بدهکار</th>
                                        <th>مانده</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($contracts as $contract)
                                        <tr>
                                            <td>
                                                @if ($contract->id)
                                                    <a href="{{ route('contracts.edit', $contract->id) }}">
                                                        {{ $contract->name }}
                                                    </a>
                                                @else
                                                    {{ $contract->name }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($contract->id)
                                                    <a href="{{ route('installments.create', $contract->id) }}">
                                                        {{ number_format($contract->debtorInstallments()->count()) }}
                                                        قسط
                                                    </a>
                                                @else
                                                    <span>
                                                        {{ number_format($contract->debtorInstallments()->count()) }}
                                                        قسط
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ number_format($contract->debtorInstallments()->sum('amount')) }}
                                                <small>تومان</small>
                                            </td>
                                            <td>
                                                @if ($contract->id)
                                                    <a href="{{ route('receives.create', $contract->id) }}">
                                                        {{ number_format($contract->total_rest) }}
                                                        <small>تومان</small>
                                                    </a>
                                                @else
                                                    {{ number_format($contract->total_rest) }}
                                                    <small>تومان</small>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            @foreach (range(1, 4) as $td)
                                                <td>-</td>
                                            @endforeach
                                        </tr>
                                    @endforelse


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


            </div>
        </x-slot>
    </x-ui.card.Card>
@endsection
