<div class="hstack justify-content-center">
    <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="ดู" class="btn m-1" type="button"
    href="{{ route("{$route}.show", $params) }}"><i class="si-search"></i></a>
    {{ $slot }}
    @can('update')
        <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="แก้ไข" class="btn btn-warning m-1" type="button"
            href="{{ route("{$route}.edit", $params) }}"><i class="si-edit"></i></a>
    @endcan
    @can('change-status')
        @php
            if (isset($model->status)) {
                $show = true;
                if ($model->getTable() === 'departments' && $model->is_main === 'yes') {
                    $route = null;
                    $title = 'ไม่สามารถปิดการใช้งาน Department หลักได้';
                    $color = 'outline-secondary disabled';
                    $icon = 'x-square';
                    $show = false;
                } elseif ($model->status === 'active') {
                    $route = route('manage.status.disable');
                    $title = 'ปิดการใช้งาน';
                    $color = 'danger';
                    $icon = 'x-square';
                } else {
                    $route = route('manage.status.reactive');
                    $title = 'Re-Active';
                    $color = 'success';
                    $icon = 'history-undo';
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
                <button class="btn btn-{{ $color }} m-1" type="submit">
                    {{-- <i data-feather="{{ $icon }}"></i> --}}
                    <i class="si-{{ $icon }}"></i>
                </button>
            </form>
        @endif
    @endcan
</div>
