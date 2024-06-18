<div>
    <form>
        <div class="input-group ">
            <input type="text" class="form-control" placeholder="ค้นหา" name="search"
                value="{{ $_GET['search'] ?? '' }}" />
            <x-button type="submit" icon="search" icon-size="20" color="outline-primary" />
            @if (isset($_GET['search']))
                <x-button icon="close" icon-size="20" color="outline-danger"
                    onclick="window.location.href='{{ request()->fullUrlWithQuery(['search' => null]) }}'" />
            @endif
        </div>
    </form>
</div>