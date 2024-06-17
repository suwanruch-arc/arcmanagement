<div>
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <p class="h4 d-flex align-items-center gap-2">
            {{$title}}
        </p>
        <div class="btn-toolbar mb-2 mb-md-0">
            {{$toolbar}}
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            {{$slot}}
        </div>
    </div>
</div>