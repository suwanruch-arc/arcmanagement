<div class="hstack">
    {{ $slot }}
    @can('update')
        <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit" class="btn btn-warning m-1" type="button"
            href="{{ route("{$route}.edit", $params) }}"><i data-feather="edit"></i></a>
    @endcan
    @can('delete')
        @if ($disable === 'active')
            <form id="disable-form" class="d-inline" method="post" action="{{ route("{$route}.destroy", $params) }}">
                @csrf
                @method('DELETE')
                @if ($disable === 'active')
                    <button data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Disable"
                        class="btn btn-danger m-1" type="submit">
                        <i data-feather="x-circle"></i>
                    </button>
                @endif
            </form>
        @endif
    @endcan
</div>
