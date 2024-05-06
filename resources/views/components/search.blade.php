<div class="accordion">
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapse" aria-expanded="false" aria-controls="collapse">
                ค้นหาข้อมูล
            </button>
        </h2>
        <div id="collapse" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <form class="row g-3">
                    @foreach ($fields as $field)
                        <div class="col-3">
                            <label class="form-label">{{ $field['label'] }}</label>
                            <input class="form-control" name="{{ $field['field'] }}" />
                        </div>
                    @endforeach
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">ค้นหา</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
