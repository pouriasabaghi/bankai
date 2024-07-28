<x-ui.collapse.Collapse id="page-settings" parentClass="page-settings d-none d-md-block">
    <div role="button" class="mb-3 btn  bg-white ">
        <i class="far fa-gear"></i>
        <br>
    </div>

    <x-slot name='content'>
        <form action="" method="GET" class="mt-n3 pt-3  pb-1 px-3 bg-white shadow-lg ">
            {{-- Pagination number --}}
            <x-ui.form.Input class="form-control-sm" col='2' label='تعداد موردها در هر برگه' name='pagination'
                value="{{ old('pagination', intval(request()->pagination) ?: get_user_pagination()) }}" type="number"
                :attr="['step' => '50', 'min' => '50']" />

        </form>
    </x-slot>
</x-ui.collapse.Collapse>
