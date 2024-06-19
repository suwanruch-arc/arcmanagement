<form action="{{ route($route, $params) }}" method="POST" autocomplete="off">
    @csrf
    @if ($method === 'PUT')
        @method($method)
    @endif
    <div>
        {{ $slot }}
    </div>
    <hr>
    <div>
        <x-button type="submit" label="บันทึก" icon="save" color="success"/>
    </div>
</form>
