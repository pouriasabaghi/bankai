<nav class="navbar navbar-expand navbar-light navbar-bg">
    <a class="sidebar-toggle js-sidebar-toggle">
        <i class="hamburger align-self-center"></i>
    </a>

    <div class="navbar-collapse collapse">
        <ul class="navbar-nav navbar-align">

            <livewire:search />

            <li class="nav-item dropdown">
                @include('admin.layouts.template.notifications')
            </li>

            <li class="nav-item dropdown">
                <a class="nav-icon dropdown-toggle" href="#" id="messagesDropdown" data-bs-toggle="dropdown">
                    <div class="position-relative">
                        <i class="align-middle" data-feather="message-square"></i>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-lg  py-0" aria-labelledby="messagesDropdown">
                    <div class="dropdown-menu-header">
                        <div class="position-relative">
                            -
                        </div>
                    </div>
                    <div class="list-group">
                        <a href="#" class="list-group-item">
                            <div class="row g-0 align-items-center">
                                <div class="col-2">
                                    <img src="{{ asset('assets/img/avatars/avatar-5.jpg') }}"
                                        class="avatar img-fluid rounded-circle" alt="Vanessa Tucker">
                                </div>
                                <div class="col-10 ps-2">
                                    <div class="text-dark">عنوان</div>
                                    <div class="text-muted small mt-1">پیام</div>
                                    <div class="text-muted small mt-1">زمان</div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="dropdown-menu-footer">
                        <a href="#" class="text-muted">Show all messages</a>
                    </div>
                </div>
            </li>



            <li class="nav-item dropdown">
                <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                    <i class="align-middle" data-feather="settings"></i>
                </a>

                <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                    {{-- <img src="{{ asset('assets/img/avatars/avatar.jpg') }}" class="avatar img-fluid rounded me-1"
                        alt="Charles Hall" />
                    --}}
                    <span class="text-dark">{{ auth()->user()->name }}
                    </span>
                </a>
                <div class="dropdown-menu text-start">
                    <a class="dropdown-item" href="{{ route('profile-admin.index') }}">
                        <i class="align-middle me-1" data-feather="user"></i>
                        پروفایل
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">خروج</a>
                </div>
            </li>

        </ul>
    </div>
</nav>
