<div class="row row-cols-1 row-cols-md-2">
    <div class="col">
        <x-input label="Name" name="name" :value="$name" required />
    </div>
    <div class="col">
        <x-input type="email" label="Email" name="email" :value="$email" required />
    </div>
</div>
@if ($type === 'create')
    <div class="row row-cols-1 row-cols-md-2">
        <div class="col">
            <x-input label="Username" name="username" :value="$username" required />
        </div>
        <div class="col">
            <x-input type="password" label="Password" name="password" required />
        </div>
    </div>
@endif
<div class="row row-cols-1 row-cols-md-2">
    <x-partner-department-select :partnerValue="$partner_id" :departmentValue="$department_id" />
</div>
<div class="row row-cols-1 row-cols-md-2">
    <div class="col">
        <x-select label="Position" name="position" :src="['admin' => 'Admin', 'leader' => 'Leader', 'staff' => 'Staff']" :value="$position" required />
    </div>
    <div class="col">
        <x-select label="Role" name="role" :src="['admin' => 'Admin', 'moderator' => 'Moderator', 'user' => 'User']" :value="$role" required />
    </div>
</div>
<div class="row row-cols-1 row-cols-md-2">
    <div class="col">
        <x-select label="Status" name="status" :src="['active' => 'ใช้งาน', 'inactive' => 'ไม่ใช้งาน']" :value="$status" required />
    </div>
    <div class="col">
        <x-input label="Contact Number" name="contact_number" :value="$contact_number" required />
    </div>
</div>
