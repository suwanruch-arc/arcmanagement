<div>
    @if ($s === 'active')
        <span class="material-symbols-rounded text-success user-select-none" data-bs-toggle="tooltip" data-bs-title="ใช้งาน">
            radio_button_checked
        </span>
    @else
        <span class="material-symbols-rounded text-secondary user-select-none" data-bs-toggle="tooltip" data-bs-title="ไม่ใช้งาน">
            radio_button_unchecked
        </span>
    @endif
</div>
