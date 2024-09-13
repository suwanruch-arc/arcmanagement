<div>
    <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#terms-model-{{$id}}">
        แสดง
    </button>

    <div class="modal fade" id="terms-model-{{$id}}" tabindex="-1" aria-labelledby="terms-model-{{$id}}-label"
        aria-hidden="true" style="font-size:1rem;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="terms-model-{{$id}}-label">Terms and Conditions</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!!$tandc!!}
                </div>
            </div>
        </div>
    </div>
</div>