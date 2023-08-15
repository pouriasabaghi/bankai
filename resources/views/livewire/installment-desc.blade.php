<div>
    <x-ui.form.Input livewire="wire:model.lazy=desc wire:change=syncDesc({{ $installmentId }}) " name='desc' class="no-form-control" placeholder='توضیحات...'/>
    <x-ui.loader.Loader livewire="wire:loading.flex" />
</div>
