<div class="row row-cols-1 row-cols-md-4">
    @foreach ($settings as $name => $value)
        <div class="col">
            <x-input :label="ucwords($name)" name="settings[{{ $name }}]" id="setting-{{ $name }}"
                :value="$value" append="px"/>
        </div>
    @endforeach
</div>
