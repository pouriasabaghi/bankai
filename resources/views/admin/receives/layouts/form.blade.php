@include('admin.receives.layouts.detail', [
    'debtor' => $detail['debtor'],
    'creditor' => $detail['creditor'],
    'creditorTitle' => $detail['creditor_title'],
    'contractReceives' => $contractReceives,
])

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
                                <hr />
                            </div>
                            <div class="col-12">
                                <a class="nav-link dropdown-toggle toggle-type-container" href="#"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="h6 mb-2 d-inline-block">اطلاعات
                                        {{-- This is first time default value and will be change with js --}}
                                        @if (!empty($receive->type) && $receive->type == 'deposit')
                                            <span class="type-label">واریز</span>
                                        @else
                                            <span class="type-label">چک</span>
                                        @endif
                                    </span>
                                </a>
                                <div class="dropdown-menu text-start">
                                    <span role="button" class="dropdown-item inside-toggle-type-buttons"
                                        data-toggle-type='deposit'>واریز</span>
                                    <span role="button" class="dropdown-item inside-toggle-type-buttons"
                                        data-toggle-type='check'>چک</span>
                                </div>
                            </div>
                            <div class="col-12 {{ ($loop->index == 0 && ((!empty($receive->type) && $receive->type != 'deposit') || empty($receive->type))) ||
                            (!empty($receive->type) && $receive->type == 'check')
                                ? ''
                                : 'd-none' }}"
                                data-type='check'>
                                <div class="row">
                                    @include('admin.receives.layouts.check-inputs')
                                </div>
                            </div>
                            <div class="col-12 {{ !empty($receive->type) && $receive->type == 'deposit' ? '' : 'd-none' }}"
                                data-type='deposit'>
                                <div class="row">
                                    @include('admin.receives.layouts.deposit-inputs')
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="col-12 text-end mt-3">
                    <div class="btn-group add-receive-toggle-type-container">
                        <div class="btn-group " role="group">
                            <button type="button" class="btn btn-outline-success dropdown-toggle"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="type-label">چک</span>
                            </button>
                            <div class="dropdown-menu text-start ">
                                <span role="button" class="dropdown-item toggle-type-buttons"
                                    data-toggle-type='deposit'>واریز</span>
                                <span role="button" class="dropdown-item toggle-type-buttons"
                                    data-toggle-type='check'>چک</span>
                            </div>
                        </div>
                        <x-ui.button.Button type='button' class="btn-sm manage-row__button no-rounded" btn='success'
                            :attr="['data-type' => 'check']">
                            افزودن
                        </x-ui.button.Button>
                    </div>
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
