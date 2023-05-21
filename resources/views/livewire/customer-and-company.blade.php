<div class="row position-relative">
    <x-ui.loader.Loader livewire="wire:loading.flex" />
    <x-ui.form.Select name='customer_id' livewire="wire:model=selectedCustomer" class="form-control _customers-select"
        script='no' col='6' label='مشتری'>
        @if ($firstTime)
            <x-ui.form.Option value="0">انتخاب مشتری</x-ui.form.Option>
        @endif
        @forelse ($customers as $customer)
            <x-ui.form.Option value="{{ $customer->id }}">{{ $customer->name }}</x-ui.form.Option>
        @empty
            <x-ui.form.Option :disabled='true' value='0'>مشتری وجود ندارد</x-ui.form.Option>
        @endforelse

    </x-ui.form.Select>

    <x-ui.form.Select name='company_id' class="form-control _companies-select" col='6' label='مجموعه'
        script='no'>
        @forelse ($companies as $company)
            <x-ui.form.Option value="{{ $company->id }}">{{ $company->name }}</x-ui.form.Option>
        @empty
            <x-ui.form.Option value='0'>مجموعه‌ای وجود ندارد</x-ui.form.Option>
        @endforelse
    </x-ui.form.Select>

    @push('scripts')
        <script>
            document.addEventListener('livewire:load', () => {
                let options = {
                    placeholder: 'انتخاب کنید',
                    language: {
                        noResults: function() {
                            return "موردی یافت نشد";
                        }
                    }
                };
                $('._customers-select').select2(options);
                $('._companies-select').select2(options);

                let selectedCustomer;
                $('._customers-select').on('select2:select', function() {
                    selectedCustomer = $(this).val();
                    @this.call('setSelectedCustomer', selectedCustomer);
                });

                window.addEventListener('enable-select2', () => {
                    $('._customers-select').select2(options).val(selectedCustomer).trigger('change');
                    $('._companies-select').select2(options);
                })
            });
        </script>
    @endpush
</div>
