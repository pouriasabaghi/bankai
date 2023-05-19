
<form method="{{ empty($method) || $method == 'get' ? 'get' : 'post' }}" action="{{ $action ?? '' }}">
    @csrf
    @method($method ?? 'get')
    {{ $slot }}
</form>
