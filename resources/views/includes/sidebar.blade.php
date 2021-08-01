<div class="wrapper">
    <nav class="sidebar sidebar-sticky">
        <div class="sidebar-content  js-simplebar">
            <a class="sidebar-brand" href="{{ url('/') }}">
                <img src="{{ asset($logo) }}" alt="Logo" class="img-fluid">
            </a>

            <ul class="sidebar-nav">
                <li class="sidebar-header">
                    Main
                </li>
                <li class="sidebar-item">
                    <a href="{{ url('backend') }}" class="font-weight-bold  sidebar-link">
                        <i class="align-middle" data-feather="home"></i> <span class="align-middle">Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ url('backend/products') }}"  class="font-weight-bold sidebar-link">
                        <i class="align-middle" data-feather="sidebar"></i> <span class="align-middle">Products</span>
                    </a>

                </li>

                <li class="sidebar-item">
                    <a href="{{ url('backend/notification') }}" class="font-weight-bold sidebar-link">
                        <i class="align-middle" data-feather="bar-chart-2"></i> <span class="align-middle">Notification</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ url('backend/subscribers') }}" class="font-weight-bold sidebar-link">
                        <i class="align-middle" data-feather="user-check"></i> <span class="align-middle">Subscribers</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="" data-toggle="collapse" class="font-weight-bold sidebar-link collapsed">
                        <i class="align-middle" data-feather="monitor"></i> <span class="align-middle">Pusher Jobs</span>
                    </a>
                    <ul id="auth" class="sidebar-dropdown list-unstyled collapse ">
                        <li class="sidebar-item"><a class="sidebar-link" href="{{ url('backend/jobs/queued') }}">queued</a></li>
                        <li class="sidebar-item"><a class="sidebar-link" href="{{ url('backend/jobs/failed') }}">Failed</a></li>

                    </ul>
                </li>

                <li class="sidebar-header">
                    Administration
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link font-weight-bold" href="{{ url('backend/user') }}">
                        <i class="align-middle" data-feather="users"></i> <span class="align-middle">Users</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link font-weight-bold" href="{{ url('backend/user/roles') }}">
                        <i class="align-middle fas fa-tasks"></i> <span class="align-middle">Roles</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link font-weight-bold" href="{{ url('backend/user/permissions') }}">
                        <i class="align-middle fas fa-door-open"></i> <span class="align-middle">Permissions</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link font-weight-bold" href="{{ url('backend/logs') }}">
                        <i class="align-middle fas fa-edit" ></i>
                        <span class="align-middle">Logs</span>
                    </a>
                </li>
            </ul>


        </div>
    </nav>

