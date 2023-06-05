<a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-bs-toggle="dropdown">
    <div class="position-relative">
        <i class="align-middle" data-feather="bell"></i>
        <span class="indicator">{{ $notifications->count() }}</span>
    </div>
</a>
<div class="dropdown-menu dropdown-menu-lg py-0" aria-labelledby="alertsDropdown">
    <div class="dropdown-menu-header">
        {{ $notifications->count() }}
        پیام جدید
    </div>
    <div class="list-group">
        @foreach ($notifications as $notification)
            <a href="#" class="list-group-item">
                <div class="row g-0 align-items-center text-start">
                    <div class="col-10">
                        <div class="text-dark">{{ $notification->data['title'] }}</div>
                        <div class="text-muted small mt-1">{{ $notification->data['message'] }}</div>
                        <div class="text-muted small mt-1">{{ jdate($notification->created_at)->ago() }}
                        </div>
                    </div>
                    <div class="col-2">
                        <i class="text-danger" data-feather="alert-circle"></i>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
    <div class="dropdown-menu-footer">
        <a href="#" class="text-muted">نمایش تمام اعلان‌ها</a>
    </div>
</div>
