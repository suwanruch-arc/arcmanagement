@php($i = 0)
<form method="GET" action="{{ route('site.reports.show', $report->uuid) }}" class="container">
    <div class="row row-cols-4 justify-content-center align-items-center">
        @foreach ($settings as $setting)
            @if ($setting->is_search === 'yes')
                <div class="col">
                    <x-input :value="$_GET[$setting->field] ?? ''" :label="$setting->label" :name="$setting->field" />
                </div>
                @php($i++)
            @endif
        @endforeach
    </div>
    @if ($i)
        <div class="row justify-content-center">
            <div class="col-2 text-end">
                <button type="submit" class="btn btn-primary">
                    <i class="material-icons-round fs-6">search</i>
                    ค้นหา
                </button>
            </div>
            <div class="col-2 text-start">
                <x-button color="link" href="{{ route('site.reports.show', $report->uuid) }}">
                    ล้าง
                </x-button>
            </div>
        </div>
    @endif
</form>

@if ($i)
    <hr>
@endif
