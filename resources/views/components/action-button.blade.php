<div class="hstack justify-content-evenly d-flex gap-1">
    <x-button tooltip="ดู" size="sm" icon="search" icon-size="20" color="info" :href="route($route . '.show', $id ?? $params)" />
    <x-button tooltip="แก้ไข" size="sm" icon="edit" icon-size="20" color="warning" :href="route($route . '.show', $id ?? $params)" />
    <x-button tooltip="ลบ" size="sm" icon="delete" icon-size="20" color="danger" :href="route($route . '.show', $id ?? $params)" />
</div>