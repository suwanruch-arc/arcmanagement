@if ($errors->any())
    <x-alert type="danger">
        <ul class="m-0">
            @foreach ($errors->all() as $error)
                <li>{!! $error !!}</li>
            @endforeach
        </ul>
    </x-alert>
@endif
<form {{ $attributes }}>
    @csrf
    {{ $slot }}
    <hr />
    <button class="btn btn-sm btn-primary d-flex align-items-center gap-2" type="submit">
        <i class="material-icons-round fs-6">save</i>
        บันทึก
    </button>
</form>
