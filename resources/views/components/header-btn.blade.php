<div class="d-flex justify-content-{{ $justify }}">
    @foreach ($buttons as $button)
        <a href="{{ $button['url'] }}" class="ms-2 btn btn-sm btn-primary d-flex align-items-center gap-2">
            {{ $button['text'] }}
        </a>
    @endforeach
    <a href="{{ url()->current() }}/create" class="ms-2 btn btn-sm btn-primary d-flex align-items-center gap-2">
        <span class="material-icons-round">add</span>
        สร้าง
    </a>
</div>
