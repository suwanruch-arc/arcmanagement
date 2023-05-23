<div class="d-flex justify-content-{{ $justify }}">
    @foreach ($buttons as $button)
        <a href="{{ $button['url'] }}"
            class="text-bg-primary text-decoration-none rounded-top mx-2 px-3 py-1 fs-6">{{ $button['text'] }}</a>
    @endforeach
    <a href="{{ url()->current() }}/create"
        class="text-bg-primary text-decoration-none rounded-top mx-2 px-3 py-1 fs-6">Create</a>
</div>
