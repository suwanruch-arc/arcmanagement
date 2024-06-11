<div class="hstack justify-content-evenly d-flex gap-1">
    {{ $slot }}
    <x-button size="sm" icon="search" tooltip="ดู" :href="route($route . '.show', $params)" />
    @can('update')
        <x-button size="sm" icon="edit" tooltip="แก้ไข" :href="route($route . '.edit', $params)" />
    @endcan
    @can('change-status')
        @php
            $show_restore = false;
            $show_destroy = false;
            if (!$model->trashed()) {
                if ($model->getTable() === 'departments' && $model->is_main === 'yes') {
                    $route = null;
                    $title = 'ไม่สามารถปิดการใช้งาน Department หลักได้';
                    $icon = 'clear';
                } else {
                    $title = 'ปิดการใช้งาน';
                    $icon = 'clear';
                    $show_destroy = true;
                }
            } else {
                if ($model->trashed()) {
                    $title = 'กู้คืน';
                    $icon = 'autorenew';
                    $show_restore = true;
                }
            }
        @endphp
        @if ($show_destroy)
            <form method="POST" action="{{route($route . '.destroy', $params)}}">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <div class="form-group">
                    <x-button is-button type="submit" size="sm" :icon="$icon" :tooltip="$title" />
                </div>
            </form>
        @endif
        @if ($show_restore)
            <form method="POST" action="{{route($route . '.restore')}}">
                {{ csrf_field() }}
                <div class="form-group">
                    <input name="id" type="hidden" value="{{$model->id}}" />
                    <x-button is-button type="submit" size="sm" :icon="$icon" :tooltip="$title" />
                </div>
            </form>
        @endif
    @endcan
</div>