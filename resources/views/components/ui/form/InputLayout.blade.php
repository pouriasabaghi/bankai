<div class="row">
    @if (isset($exception))
        <div class="alert alert-danger">
            {{ $exception->getMessage() }}
        </div>
    @endif


    @if ($errors->any())
        <div class="col-12">
            <div class="alert alert-danger">
                <ul class='mb-0 mx-4'>
                    @foreach ($errors->all() as $error)
                        <li class="my-2">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
    {{ $slot }}
</div>
