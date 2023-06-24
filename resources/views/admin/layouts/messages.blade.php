@if ($messages = session('messages'))
    <div class="{{ $class ?? '' }}">
        @foreach ($messages as $message)
            <x-ui.alert.Alert alert="{{ $message['type'] }}">
                {{ $message['text'] }}
            </x-ui.alert.Alert>
        @endforeach
    </div>
@endif
