<x-ui.form.Form method="{{ $formAttributes['method'] }}" action="{{ $formAttributes['action'] }}">
    <x-ui.form.InputLayout>
        <x-ui.form.Input name="name" value="{{ old('name', $contract->name ?? '') }}" label="عنوان قرارداد"  />

        {{-- List of customers and companies  --}}
        <div class="col-12">
            <livewire:customer-and-company />
        </div>

        <div class="col-md-6">
            <x-ui.button.Button>
                ذخیره
            </x-ui.button.Button>
        </div>
    </x-ui.form.InputLayout>
</x-ui.form.Form>
