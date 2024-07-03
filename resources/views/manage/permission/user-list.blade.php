<div>
    <table class="table table-bordered" width="100%">
        <thead>
            <tr>
                <th class="text-center" width="5%">#</th>
                <th class="text-center" width="95%">ชื่อ</th>
            </tr>
        </thead>
        @foreach ($users as $user)
            <tr>
                <td class="td-center">
                    <input class="form-check-input" name="user_id" id="user_id_{{ $user->id }}" value="{{ $user->id }}" type="radio" />
                </td>
                <td>
                    <label for="user_id_{{ $user->id }}">{{ $user->name }}</label>
                </td>
            </tr>
        @endforeach
    </table>
    {!! $users->onEachSide(1)->links() !!}
</div>
