<div class="{{ $class ?? '' }}">
    {{ $paginate->appends(request()->all())->links('pagination') }}
</div>
