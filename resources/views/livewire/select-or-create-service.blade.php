<div class="row position-relative">
    <x-ui.loader.Loader livewire="wire:loading.flex" />
    <x-ui.form.Select livewire="wire:model=servicesList" class="form-control _services-select" name='services[]' col='10 col-10' label='خدمات' multiple='true'
        script='no'>
        @forelse ($services as $service)
            <x-ui.form.Option value="{{ $service->id }}">{{ $service->name }}</x-ui.form.Option>
        @empty
            <x-ui.form.Option :disabled='true' value='null'>خدمت یافت نشد</x-ui.form.Option>
        @endforelse
    </x-ui.form.Select>

    <div class="col-md-2 col-3 mt-auto mb-3 " wire:ignore>
        <x-ui.button.Button class="add-new-service__button" type='button' btn='success'>
            <i class="fa-solid fa-plus"></i>
        </x-ui.button.Button>
    </div>

    <div class="row add-new-service__box" wire:ignore.self>
        <x-ui.form.Input livewire="wire:model.debounce.500ms=service_name" name='service_name' label='عنوان خدمت جدید'
            col='10 col-9' class="form-control-sm" />

        <div class="col-md-2 col-3 mt-auto mb-4">
            <x-ui.button.Button type='button' livewire="wire:click=store" btn='success' class="btn-sm">
                افزودن
            </x-ui.button.Button>
        </div>
    </div>

    @if (session()->has('message'))
        <x-ui.alert.Alert>
            {{ session('message') }}
        </x-ui.alert.Alert>
    @endif


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
                $('._services-select').select2(options);

                // // save previoues selected values ;
                // let values = [];

                // // add selected items to values. this cuase save previous select if user fist choice some
                // // items then add new one
                $('._services-select').on('select2:select', function() {
                    let selectedServices = $(this).val();

                    @this.call('keepSelectedServiceUpdate', selectedServices);
                });


                // // enable select to after response
                window.addEventListener('enable-select2-services', (event) => {
                    $('._services-select').select2(options)
                })
            });

            const addNewServiceButton = document.querySelector('.add-new-service__button')
            addNewServiceButton && addNewServiceButton.addEventListener('click', (e) => {
                const newServiceBox = document.querySelector('.add-new-service__box');
                const icon = e.target.closest('button').querySelector('i');
                newServiceBox && newServiceBox.classList.toggle('active')
                if (newServiceBox.classList.contains('active')) {
                    icon.classList.remove('fa-plus')
                    icon.classList.add('fa-minus')
                } else {
                    icon.classList.add('fa-plus')
                    icon.classList.remove('fa-minus')
                }
            })
        </script>
    @endpush
</div>
