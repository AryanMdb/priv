<nav class="sidebar sidebar-offcanvas overflow-auto h-100" id="sidebar">
  <a class="navbar-brand brand-logo mt-3 d-block text-center mx-0" href="/">
    <img src="{{asset('images/logo3.png')}}" style="width: 150px; border-radius: 8px;" />
  </a>
  <div class="nav-item nav-profile text-center">
    <a href="{{route('dashboard')}}" class="nav-link justify-content-center px-0">
      <div class="text-wrapper">
        <p class="profile-name text-white mb-0">{{auth()->user()->name}}</p>
        <p class="designation text-gray">Sub Administrator</p>
      </div>
    </a>
  </div>
  <ul class="nav">
    <li class="nav-item">
      <a class="nav-link" href="{{route('dashboard-page')}}">
        <span class="menu-title">Dashboard</span>
        <i class="icon-screen-desktop menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{route('order-manage.index')}}">
        <span class="menu-title">Orders Manage</span>
        <i class="icon-magnifier menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#auth1" aria-expanded="false" aria-controls="auth1">
        <span class="menu-title">Settings</span>
        <i class="icon-arrow-down menu-icon"></i>
      </a>
      <div class="collapse" id="auth1">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="{{ route('my-profile') }}">My Profile</a></li>
          <li class="nav-item"> <a class="nav-link" href="{{ route('change-password') }}">Change Password</a></li>
          <li class="nav-item"> 
            <form action="{{ route('admin.logout') }}" method="POST">
              @csrf
              <a class="nav-link" href="#"><button type="submit" style="background: none; border: none;">Sign Out</button></a>
            </form>
          </li>
        </ul>
      </div>
    </li>
  </ul>
</nav>
