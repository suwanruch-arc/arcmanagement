@if ($errors->any())
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <ul class="m-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form {{ $attributes }} enctype="multipart/form-data">
    @csrf
    {{ $slot }}
    <button class="btn btn-success mt-3" type="submit"><i class="material-icons-round fs-5">save</i> บันทึก</button>
</form>
