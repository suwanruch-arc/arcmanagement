<div class="hstack">
    {{ $slot }}
    @can('update')
        <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="แก้ไข" class="btn btn-warning m-1" type="button"
            href="{{ route("{$route}.edit", $params) }}"><i data-feather="edit"></i></a>
    @endcan
    @can('change-status')
        @php
            $show = true;
            if ($model->getTable() === 'departments' && $model->is_main === 'yes') {
                $route = null;
                $title = 'ไม่สามารถปิดการใช้งาน Department หลักได้';
                $color = 'outline-secondary disabled';
                $icon = 'x-circle';
            } elseif ($model->status === 'active') {
                $route = route('manage.status.disable');
                $title = 'ปิดการใช้งาน';
                $color = 'danger';
                $icon = 'x-circle';
            } else {
                $route = route('manage.status.reactive');
                $title = 'Re-Active';
                $color = 'success';
                $icon = 'refresh-cw';
            }
        @endphp
        @if ($show)
            <form data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ $title }}" id="change-status-form"
                data-model="{{ $model->getTable() }}" class="d-inline" method="post" action="{{ $route }}">
                @csrf
                <button class="btn btn-{{ $color }} m-1" type="submit">
                    <i data-feather="{{ $icon }}"></i>
                </button>
            </form>
        @endif
    @endcan
</div>
