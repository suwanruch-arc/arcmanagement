<div>
    <div class="d-grid gap-2 d-md-block">
        @can('update')
            <a class="btn btn-warning" type="button" href="{{ route("{$route}.edit", $params) }}"><i
                    data-feather="edit"></i></a>
        @endcan
        @can('delete')
            <form class="d-inline" method="post" action="{{ route("{$route}.destroy", $params) }}">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger" type="submit"><i data-feather="trash-2"></i></button>
            </form>
        @endcan
    </div>
</div>
