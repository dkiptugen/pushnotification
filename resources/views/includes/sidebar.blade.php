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
                    <a href="{{ route('product.index') }}"  class="font-weight-bold sidebar-link">
                        <i class="align-middle" data-feather="sidebar"></i> <span class="align-middle">Products</span>
                    </a>

                </li>


                <li class="sidebar-item">
                    <a href="#notification" data-toggle="collapse" class="font-weight-bold sidebar-link collapsed">
                        <i class="align-middle" data-feather="bar-chart-2"></i> <span class="align-middle">Notification</span>
                    </a>
                    <ul id="notification" class="sidebar-dropdown list-unstyled collapse ">
                        @foreach(\App\Models\Product::where('status',1)->get() as $value)
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('product.notification.index',$value->id) }}">{{ $value->domain }}</a>
                        </li>
                        @endforeach
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="#subscription" data-toggle="collapse" class="font-weight-bold sidebar-link collapsed">
                        <i class="align-middle" data-feather="user-check"></i> <span class="align-middle">Subscribers</span>
                    </a>
                    <ul id="subscription" class="sidebar-dropdown list-unstyled collapse ">
                        @foreach(\App\Models\Product::where('status',1)->get() as $value)
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="{{ route('product.subscribers.index',$value->id) }}">{{ $value->domain }}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>

                <li class="sidebar-header">
                    Pusher Jobs
                </li>
                <li class="sidebar-item">

                    <a class="sidebar-link font-weight-bold " href="{{ url('backend/jobs/queued') }}"><i class="align-middle" data-feather="wind"></i>Queued</a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link font-weight-bold " href="{{ url('backend/jobs/failed') }}"><i class="align-middle" data-feather="monitor"></i>Failed</a>
                </li>
                <li class="sidebar-header">
                    Prime
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('prime-subscribers.index') }}" class="font-weight-bold sidebar-link">
                        <i class="align-middle fas fa-users" ></i> <span class="align-middle">Subscriber</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('prime-transactions.index') }}" class="font-weight-bold sidebar-link">
                        <i class="align-middle fas fa-cash-register" ></i> <span class="align-middle">Transactions</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('prime-content.index') }}" class="font-weight-bold sidebar-link">
                        <i class="align-middle fas fa-book" ></i> <span class="align-middle">Content</span>
                    </a>
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
                    <a class="sidebar-link font-weight-bold" href="{{ route('user.roles.index',0) }}">
                        <i class="align-middle fas fa-tasks"></i> <span class="align-middle">Roles</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link font-weight-bold" href="{{ route('user.permissions.index',0) }}">
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

