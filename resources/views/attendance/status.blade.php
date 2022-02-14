@if ($status == \App\Enums\AttendanceOption::Present)
<span class="badge badge-primary">{{ \App\Enums\AttendanceOption::getKey($status) }}</span>

@elseif($status == \App\Enums\AttendanceOption::Absence)
<span class="badge badge-danger">{{ \App\Enums\AttendanceOption::getKey($status) }}</span>

@else
<span class="badge badge-warning">{{ \App\Enums\AttendanceOption::getKey($status) }}</span>
@endif
