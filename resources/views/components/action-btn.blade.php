<div class="hstack justify-content-center">
    <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="ดู" class="btn btn-sm m-1" type="button"
    href="{{ route("{$route}.show", $params) }}"><i class="material-icons-round fs-6">search</i></a>
    {{ $slot }}
    @can('update')
        <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="แก้ไข" class="btn btn-sm btn-warning m-1" type="button"
            href="{{ route("{$route}.edit", $params) }}"><i class="material-icons-round fs-6">edit</i></a>
    @endcan
    @can('change-status')
        @php
            if (isset($model->status)) {
                $show = true;
                if ($model->getTable() === 'departments' && $model->is_main === 'yes') {
                    $route = null;
                    $title = 'ไม่สามารถปิดการใช้งาน Department หลักได้';
                    $color = 'outline-secondary disabled';
                    $icon = 'clear';
                    $show = false;
                } elseif ($model->status === 'active') {
                    $route = route('manage.status.disable');
                    $title = 'ปิดการใช้งาน';
                    $color = 'danger';
                    $icon = 'clear';
                } else {
                    $route = route('manage.status.reactive');
                    $title = 'Re-Active';
                    $color = 'success';
                    $icon = 'undo';
                }
            } else {
                $show = false;
            }
        @endphp
        @if ($show)
            <form data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ $title }}" id="change-status-form"
                data-model="{{ $model->getTable() }}" data-id="{{ $model->id }}" class="d-inline" method="post"
                action="{{ $route }}">
                @csrf
                <button class="btn btn-sm btn-{{ $color }} m-1" type="submit">
                    <i class="material-icons-round fs-6">{{ $icon }}</i>
                </button>
            </form>
        @endif
    @endcan
</div>
