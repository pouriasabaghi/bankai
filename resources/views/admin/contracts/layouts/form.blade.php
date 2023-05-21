<x-ui.form.Form method="{{ $formAttributes['method'] }}" action="{{ $formAttributes['action'] }}">
    <x-ui.form.InputLayout>
        <x-ui.form.Input name="name" value="{{ old('name', $contract->name ?? '') }}" label="عنوان قرارداد" />

        {{-- List of customers and companies  --}}
        <div class="col-md-12">
            <livewire:customer-and-company />
        </div>

        <x-ui.form.Select class="form-control" name='type' col='6' label='دسته‌بندی خدمات'>
            @if ($formAttributes['isUpdate'])
                {{-- maybe contarct type has been deleted and no select match. this stand for default value --}}
                <x-ui.form.Option value="{{ $contract->type }}">{{ $contract->type }}</x-ui.form.Option>
            @endif

            @forelse ($types as $type)
                @if ($formAttributes['isUpdate'])
                    {{-- remove duplicate option from previous default --}}
                    @if ($contact->type != $type->type)
                        <x-ui.form.Option value="{{ $type->name }}">{{ $type->name }}</x-ui.form.Option>
                    @endif
                @else
                    <x-ui.form.Option value="{{ $type->name }}">{{ $type->name }}</x-ui.form.Option>
                @endif
            @empty
                <x-ui.form.Option :disabled='true' value='null'>دسته‌بندی یافت نشد</x-ui.form.Option>
            @endforelse
        </x-ui.form.Select>

        <div class="col-md-6">
            <livewire:select-or-create-service />
        </div>

        <div class="col-md-6">
            <x-ui.button.Button>
                ذخیره
            </x-ui.button.Button>
        </div>
    </x-ui.form.InputLayout>
</x-ui.form.Form>
