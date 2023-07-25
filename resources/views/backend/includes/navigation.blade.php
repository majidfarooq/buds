<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="d-flex align-items-center justify-content-center" href="{{route('admin.dashboard')}}">
    <img src="{{ asset('/public/assets/backend/img/buds_logo.png')}}">

  </a>

  <!-- Divider -->
  <!-- Nav Item - Dashboard -->
  <li class="nav-item active">
    <a class="nav-link" href="{{route('admin.dashboard')}}">
        <div class="sidebar-img">
        <img src="{{ asset('/public/assets/backend/img/dashboard.png')}}">
        </div>
        <span>Dashboard</span></a>
  </li>

    @if (Auth::user()->role == 'super_admin')
        <!-- Divider -->
            <li class="nav-item">
                <a class="nav-link" href="{{route('admin.subadmins.list')}}">
                    <div class="sidebar-img">
                        <i class="fas fa-fw fa-user"></i>
                    </div>
                    <span>Administrators</span>
                </a>
            </li>
    @else
    @endif

  <li class="nav-item">
        <a class="nav-link" href="{{route('admin.users.index')}}">
            <div class="sidebar-img">
            <img src="{{ asset('/public/assets/backend/img/customers.png')}}">
            </div>
            <span>Customers</span>
        </a>
    </li>

     <li class="nav-item">
        <a class="nav-link" href="{{route('admin.user_packages.index')}}">
            <div class="sidebar-img">
            <img src="{{ asset('/public/assets/backend/img/subscription.png')}}">
            </div>
            <span>Subscriptions</span>
        </a>
    </li>

  <li class="nav-item">
    <a class="nav-link" href="{{route('admin.packages.index')}}">
        <div class="sidebar-img">
        <img src="{{ asset('/public/assets/backend/img/package.png')}}">
        </div>
        <span>Packages</span>
    </a>
  </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.delivery_days.show', 0) }}">
            <div class="sidebar-img">
            <img src="{{ asset('/public/assets/backend/img/delivery.png')}}">
            </div>
            <span>Deliveries</span>
        </a>
    </li>
    {{-- <li class="nav-item">
        <a class="nav-link" href="{{route('admin.delivery_days.index')}}">
            <div class="sidebar-img">
            <img src="{{ asset('/public/assets/backend/img/delivery.png')}}">
            </div>
            <span>Delivery Days</span>
        </a>
    </li> --}}
    <li class="nav-item">
        <a class="nav-link" href="{{route('admin.transactions.index')}}">
            <div class="sidebar-img">
                <img src="{{ asset('/public/assets/backend/img/delivery.png')}}">
            </div>
            <span>Transaction</span>
        </a>
    </li>


</ul>
