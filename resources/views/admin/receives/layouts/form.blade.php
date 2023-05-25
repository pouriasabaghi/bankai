{{-- @include('admin.installments.layouts.detail', [
    'total_price' => $contract->total_price,
    'total_price_str' => $contract->total_price_str,
    'period' => $contract->period,
]) --}}

<x-ui.form.Form method="{{ $formAttributes['method'] }}" action="{{ $formAttributes['action'] }}">
    <x-ui.form.InputLayout>
        <div class="col-12">
            <div class="row manage-row__group">
                @foreach ($receives as $receive)
                    <div class="col-12 manage-row__items {{ $loop->index == 0 ? '' : 'mt-3' }}
                        {{ $loop->index == 0 || !empty($receive->created_at) ? '' : 'd-none' }}"
                        data-row-count="{{ $loop->index + 1 }}">
                        <div class="d-flex align-items-center mb-2">
                            <i role='button'
                                class="fa-solid fa-circle-xmark fa-lg align-items-center d-flex fa-solid  me-2
                                {{ $loop->index == 0 ? 'text-secondary' : 'text-danger manage-row__button_delete' }}">
                            </i>
                            <h6 class="mb-0">دریافتی شماره {{ $loop->index + 1 }}</h6>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="row">
                                    @include('admin.receives.layouts.default-inputs')
                                </div>
                            </div>
                            <div class="col-12">
                                <hr/>
                            </div>
                            <div class="col-12" data-type='check'>
                                <div class="row">
                                    <h6>اطلاعات چک</h6>
                                    @include('admin.receives.layouts.check-inputs')
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="col-12 text-end mt-3">
                    <x-ui.button.Button type='button' class="btn-sm manage-row__button" btn='success'>
                        افزودن
                    </x-ui.button.Button>
                </div>
            </div>
        </div>
        <div class="col-md-6">

            <x-ui.button.Button class="submit-form">
                ذخیره
            </x-ui.button.Button>
        </div>
    </x-ui.form.InputLayout>
</x-ui.form.Form>
