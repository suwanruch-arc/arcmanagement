<div class="hstack justify-content-center d-flex gap-1">
    <x-button size="sm" icon="search" tooltip="ดู" :href="route($route . '.show', $params)" />
    {{ $slot }}
    @can('update')
        <x-button size="sm" icon="edit" tooltip="แก้ไข" :href="route($route . '.edit', $params)" />
    @endcan
    @can('change-status')
        @php
            $show = false;
            if (isset($model->status)) {
                if ($model->getTable() === 'departments' && $model->is_main === 'yes') {
                    $route = null;
                    $title = 'ไม่สามารถปิดการใช้งาน Department หลักได้';
                    $icon = 'clear';
                } elseif ($model->status === 'active') {
                    $route = route('manage.status.disable');
                    $title = 'ปิดการใช้งาน';
                    $icon = 'clear';
                    $show = true;
                } else {
                    $route = route('manage.status.reactive');
                    $title = 'เปิดการใช้งาน';
                    $icon = 'autorenew';
                    $show = true;
                }
            }
        @endphp
        @if ($show)
            <x-button size="sm" :icon="$icon" :tooltip="$title" onclick="changeStatus($model->id)" />
        @endif
    @endcan
</div>
