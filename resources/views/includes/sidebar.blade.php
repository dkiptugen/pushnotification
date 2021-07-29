<div class="wrapper">
    <nav class="sidebar sidebar-sticky">
        <div class="sidebar-content  js-simplebar">
            <a class="sidebar-brand" href="{{ url('/') }}">
                <i class="align-middle" data-feather="send"></i>
                <span class="align-middle">Boxraft Notification</span>
            </a>

            <ul class="sidebar-nav">
                <li class="sidebar-header">
                    Main
                </li>
                <li class="sidebar-item">
                    <a href="" class="font-weight-bold  sidebar-link">
                        <i class="align-middle" data-feather="home"></i> <span class="align-middle">Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ url('subscribers/view') }}"  class="font-weight-bold sidebar-link">
                        <i class="align-middle" data-feather="sidebar"></i> <span class="align-middle">Subscribers</span>
                    </a>

                </li>

                <li class="sidebar-item">
                    <a href="{{ url('stories') }}" class="font-weight-bold sidebar-link">
                        <i class="align-middle" data-feather="bar-chart-2"></i> <span class="align-middle">Post</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ url('failed_jobs') }}" class="font-weight-bold sidebar-link ">
                        <i class="align-middle" data-feather="check-square"></i> <span class="align-middle">Failed jobs</span>
                    </a>

                </li>
                <li class="sidebar-item">
                    <a href="{{ url('queued_jobs') }}" class="font-weight-bold sidebar-link">
                        <i class="align-middle" data-feather="list"></i> <span class="align-middle">Queued Jobs</span>
                    </a>

                </li>

                <li class="sidebar-header">
                    Administration
                </li>
<!--                <li class="sidebar-item">
                    <a href="pages-blank.html#auth" data-toggle="collapse" class="font-weight-bold sidebar-link collapsed">
                        <i class="align-middle" data-feather="monitor"></i> <span class="align-middle">Auth</span>
                    </a>
                    <ul id="auth" class="sidebar-dropdown list-unstyled collapse ">
                        <li class="sidebar-item"><a class="sidebar-link" href="pages-sign-in.html">Sign In</a></li>
                        <li class="sidebar-item"><a class="sidebar-link" href="pages-sign-up.html">Sign Up</a></li>
                        <li class="sidebar-item"><a class="sidebar-link" href="pages-reset-password.html">Reset Password</a></li>
                        <li class="sidebar-item"><a class="sidebar-link" href="pages-profile.html">Profile <span class="sidebar-badge badge badge-primary">New</span></a></li>
                        <li class="sidebar-item"><a class="sidebar-link" href="pages-settings.html">Settings <span class="sidebar-badge badge badge-primary">New</span></a></li>
                    </ul>
                </li>-->

                <li class="sidebar-item">
                    <a class="sidebar-link font-weight-bold" href="">
                        <i class="align-middle" data-feather="book-open"></i> <span class="align-middle">Users</span>
                    </a>
                </li>
            </ul>


        </div>
    </nav>

