<!--begin::Header-->
<nav class="app-header navbar navbar-expand bg-body">
  <!--begin::Container-->
  <div class="container-fluid">
      <!--begin::Start Navbar Links-->
      <ul class="navbar-nav">
          <li class="nav-item">
              <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                  <i class="bi bi-list"></i>
              </a>
          </li>
          <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Home</a></li>
          <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Contact</a></li>
      </ul>
      <!--end::Start Navbar Links-->

      <!--begin::End Navbar Links-->
      <ul class="navbar-nav ms-auto">
          <!-- Authentication Links -->
          @if (Route::has('login'))
              @auth
                  <!-- Dashboard Link -->
                  <li class="nav-item">
                      <a href="{{ url('/dashboard') }}" class="nav-link">Dashboard</a>
                  </li>

                  <!-- User Menu Dropdown -->
                  <li class="nav-item dropdown user-menu">
                      <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                          <img src="{{ asset('assets/images/avatar2.png') }}" class="user-image rounded-circle shadow" alt="User Image">
                          <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                      </a>
                      <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                          <!-- User Info -->
                          <li class="user-header text-bg-primary">
                              <img src="{{ asset('assets/images/avatar2.png') }}" class="rounded-circle shadow" alt="User Image">
                              <p>
                                  {{ Auth::user()->name }} - {{ Auth::user()->email }}
                                  <small>Member since {{ Auth::user()->created_at->format('M. Y') }}</small>
                              </p>
                          </li>

                          <!-- Profile and Logout -->
                          <li class="user-footer">
                              <a href="{{ url('/profile') }}" class="btn btn-default btn-flat">Profile</a>

                              <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                  @csrf
                                  <button type="submit" class="btn btn-default btn-flat float-end">Sign Out</button>
                              </form>
                          </li>
                      </ul>
                  </li>
              @else
                  <!-- Login Link -->
                  <li class="nav-item">
                      <a href="{{ route('login') }}" class="nav-link">Log in</a>
                  </li>

                  <!-- Register Link -->
                  @if (Route::has('register'))
                      <li class="nav-item">
                          <a href="{{ route('register') }}" class="nav-link">Register</a>
                      </li>
                  @endif
              @endauth
          @endif
      </ul>
      <!--end::End Navbar Links-->
  </div>
  <!--end::Container-->
</nav>
<!--end::Header-->
