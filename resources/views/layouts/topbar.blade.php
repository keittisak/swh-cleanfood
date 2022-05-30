<!-- Navbar -->
<nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fa fa-user"></i>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
          <!-- Message Start -->
          <div class="media">
              <img src="{{ asset('img/49035_face-2.jpg') }}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
              <h3 class="dropdown-item-title">
                  {{ (Auth::user()->name)?Auth::user()->name:''}}
              </h3>
              <p class="text-sm text-muted"><i class="fa fa-circle text-success mr-1"></i> Online</p>
              </div>
          </div>
          <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item dropdown-footer">Sign Out</a>
          <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
      </div>
      </li>
  </ul>
</nav>
<!-- /.navbar -->