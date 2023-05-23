<div class="row row-cols-1 row-cols-md-2">
    <div class="col">
        <x-input label="Name" name="name" :value="$name" required />
    </div>
    <div class="col">
        <x-input label="Keyword" name="keyword" :value="$keyword" required />
    </div>
</div>
@if ($type === 'create')
    <div class="row row-cols-1 row-cols-md-2">
        <div class="col">
            <x-input label="Department Name" name="department_name" :value="$department_name" required />
        </div>
        <div class="col">
            <x-input label="Department Keyword" name="department_keyword" :value="$department_keyword" required />
        </div>
    </div>
@endif
<div class="row mb-3">
    <div class="col">
        <x-file-input label="Logo File" name="logo" />
        <div class="text-center">
            <img style="height: 150px; width:150px;object-fit: cover;"
                src="https://pbs.twimg.com/media/FgQvzoCWAAIt8ag.jpg" class="rounded img-thumbnail" alt="...">
        </div>
    </div>
</div>
