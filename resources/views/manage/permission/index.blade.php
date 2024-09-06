@extends('layouts.master', ['breadcrumb' => [['url' => route('dashboard'), 'label' => 'แดชบอร์ด'], ['label' => 'จัดการสิทธิ์']]])

@section('content')
    <x-section>
        <x-slot name="title">
            <span class="material-symbols-rounded">
                format_list_bulleted
            </span>
            จัดการสิทธิ์
        </x-slot>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3">
                                    <label for="menu" class="form-label d-flex justify-content-between">
                                        <span>เมนู</span>
                                        <span class="text-danger" id="deselect-menu-lists" role="button"
                                            style="display: none">(deselect)</span>
                                    </label>
                                    <select class="form-select mb-3" size="7" id="menu-lists" disabled>
                                        @foreach (config('menu') as $menu)
                                            @if (isset($menu['id']))
                                                <optgroup label="{{ $menu['label'] }}">
                                                    @if (isset($menu['children']) && !empty($menu['children']) && isset($menu['id']))
                                                        @foreach ($menu['children'] as $children)
                                                            <option value="{{ $children['id'] ?? null }}">
                                                                {{ $children['label'] }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </optgroup>
                                            @endif
                                        @endforeach
                                    </select>
                                    <label for="partner" class="form-label">
                                        <span>Partner / Department</span>
                                    </label>
                                    <select class="form-select mb-3" size="7" id="partner-lists" disabled>
                                        <option value="all" selected>ผู้ใช้งานทั้งหมด</option>
                                        @foreach ($partners as $partner)
                                            <optgroup label="{{ $partner->name }}">
                                                @foreach ($partner->departments as $department)
                                                    <option value="{{ $department->id }}">
                                                        {{ $department->name }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4">
                                    <label for="search-user" class="form-label">ผู้ใช้งาน</label>
                                    <x-input.text type="text" id="search-user" placeholder="ค้นหา" label="ค้นหา" />
                                    <select class="form-select" size="15" multiple id="user-lists" disabled></select>
                                </div>
                                <div class="col-1 d-flex justify-content-center align-items-center">
                                    <div class="d-grid gap-2">
                                        <x-button color="secondary" size="sm" label=">"
                                            class="justify-content-center" id="add" disabled />
                                        <x-button color="secondary" size="sm" label="<"
                                            class="justify-content-center" id="remove" disabled />
                                        <br>
                                        <x-button color="secondary" size="sm" label=">>"
                                            class="justify-content-center" id="add-all" disabled />
                                        <x-button color="secondary" size="sm" label="<<"
                                            class="justify-content-center" id="remove-all" disabled />
                                        <br>
                                        <x-button color="success" label="บันทึก" id="save" disabled />
                                    </div>
                                </div>
                                <div class="col-4">
                                    <label for="search-permission" class="form-label">ผู้ใช้งานที่มีสิทธิ์</label>
                                    <x-input.text type="text" id="search-permission" placeholder="ค้นหา"
                                        label="ค้นหา" />
                                    <select class="form-select" size="15" multiple id="permission-lists"
                                        disabled></select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-section>
@endsection

@section('script')
    @parent
    <script>
        $(document).ready(() => {
            const menuLists = $('#menu-lists');
            const partnerLists = $('#partner-lists');
            const deselectMenuLists = $('#deselect-menu-lists');
            const userLists = $('#user-lists');
            const permissionLists = $('#permission-lists');
            const addBtn = $('#add');
            const removeBtn = $('#remove');
            const addAllBtn = $('#add-all');
            const removeAllBtn = $('#remove-all');
            const saveBtn = $('#save')
            const searchUser = $('#search-user');
            const searchPermission = $('#search-permission')

            const savePermission = async () => {
                const menu = menuLists.val();
                const permissionListValues = $.map($('#permission-lists option'), function(option) {
                    return $(option).val();
                });
                if (!menu) return;
                try {
                    const response = await $.ajax({
                        type: "POST",
                        url: route('manage.permissions.users.save', menu),
                        dataType: "JSON",
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            user_id: permissionListValues
                        },
                    });
                    
                    Swal.fire({
                        toast: true,
                        title: 'การแจ้งเตือน',
                        html: response.message,
                        icon: 'success',
                        position: "top-end",
                        timer: 5000,
                        timerProgressBar: true,
                        showConfirmButton: false,
                    })
                } catch (error) {
                    console.error('Error saving data:', error);
                }
            }

            const fetchPermissions = async (menu) => {
                try {
                    const users = await $.ajax({
                        type: "GET",
                        url: route('manage.permissions.get', menu),
                        dataType: "JSON"
                    });

                    permissionLists.empty();
                    users.forEach(data => {
                        permissionLists.append(new Option(data.user.name, data.user.id));
                    });
                    fetchUsers()
                    permissionLists.prop('disabled', false);
                    toggleSwitchBtn(false)
                    compareUsers()
                } catch (error) {
                    console.error('Error fetching permissions:', error);
                }
            }

            menuLists.on('change', (e) => {
                fetchPermissions(e.target.value);
            });

            const fetchUsers = async (department = 'all') => {
                try {
                    const users = await $.ajax({
                        type: "GET",
                        url: route('manage.permissions.users.get', department),
                        dataType: "JSON"
                    });

                    userLists.empty();
                    users.forEach(user => {
                        userLists.append(new Option(user.name, user.id));
                    });
                    userLists.prop('disabled', false);
                    menuLists.prop('disabled', false);
                    partnerLists.prop('disabled', false);
                    compareUsers()
                } catch (error) {
                    console.error('Error fetching users:', error);
                }
            };

            partnerLists.on('change', (e) => {
                fetchUsers(e.target.value);
            });

            const compareUsers = () => {
                const selectedValues = permissionLists.find('option').map((_, option) => $(option)
                        .val())
                    .get();

                userLists.find('option').each((_, option) => {
                    const $option = $(option);
                    if (selectedValues.includes($option.val())) {
                        $option.remove();
                    }
                });

            }

            const toggleSwitchBtn = (toggle) => {
                addBtn.prop('disabled', toggle)
                removeBtn.prop('disabled', toggle)
                addAllBtn.prop('disabled', toggle)
                removeAllBtn.prop('disabled', toggle)
                saveBtn.prop('disabled', toggle)
            }

            const moveSelectedOptions = (fromSelect, toSelect, all = false) => {
                const options = all ? $(`${fromSelect} option`) : $(fromSelect).find('option:selected');
                if (options.length) {
                    $(toSelect).append(options.clone());
                    options.remove();
                    sortOptions(fromSelect);
                    sortOptions(toSelect);
                }
            };

            const sortOptions = (selectElement) => {
                const options = $(`${selectElement} option`).sort((a, b) => {
                    return $(a).text().localeCompare($(b).text());
                });
                $(selectElement).html(options);
            };

            const searchOptions = (input, selectId) => {
                const searchText = $(input).val().toLowerCase();
                $(`${selectId} option`).each(function() {
                    const optionText = $(this).text().toLowerCase();
                    $(this).toggle(optionText.includes(searchText));
                });
            }

            addBtn.on('click', () => moveSelectedOptions('#user-lists', '#permission-lists'));
            removeBtn.on('click', () => moveSelectedOptions('#permission-lists', '#user-lists'));
            addAllBtn.on('click', () => moveSelectedOptions('#user-lists', '#permission-lists', true));
            removeAllBtn.on('click', () => moveSelectedOptions('#permission-lists', '#user-lists', true));
            saveBtn.on('click', () => savePermission())

            searchUser.on('keyup', function() {
                searchOptions(this, '#user-lists');
            });

            searchPermission.on('keyup', function() {
                searchOptions(this, '#permission-lists');
            });

            // Initialize the states on page load
            fetchUsers();
            toggleSwitchBtn(true)
        });
    </script>
@endsection
