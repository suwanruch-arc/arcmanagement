<div>
    @if ($errors->any())
        <div
            class="alert alert-danger alert-dismissible py-2 px-1"
            role="alert"
        >
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>
            <ul class="m-0">
                @foreach ($errors->all() as $error)
                    <li>{!! $error !!}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form
        action="{{ route($route, $params) }}"
        method="POST"
        autocomplete="off"
        enctype="multipart/form-data"
    >
        @csrf
        @if ($method === 'PUT')
            @method($method)
        @endif
        <div>
            {{ $slot }}
        </div>
        <hr>
        <div>
            <x-button
                type="submit"
                label="บันทึก"
                icon="save"
                color="success"
            />
        </div>
    </form>
</div>
