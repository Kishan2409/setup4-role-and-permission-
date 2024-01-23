  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

      <ul class="sidebar-nav" id="sidebar-nav">

          <li class="nav-item">
              <a class="nav-link {{ request()->is('/dashboard') ? 'active' : '' }}" href="{{ url('/dashboard') }}">
                  <i class="fa-solid fa-gauge"></i>&nbsp;Dashboard
              </a>
          </li>

          @permission('view.client')
              <li class="nav-item">
                  <a class="nav-link {{ request()->is('/client') ? 'active' : '' }}" href="{{ url('/client') }}">
                      <i class="fa-solid fa-users"></i>&nbsp;Client
                  </a>
              </li>
          @endpermission

          @permission('view.user')
              <li class="nav-item">
                  <a class="nav-link {{ request()->is('/user') ? 'active' : '' }}" href="{{ url('/user') }}">
                      <i class="fa-solid fa-user"></i>&nbsp;User
                  </a>
              </li>
          @endpermission

      </ul>

  </aside><!-- End Sidebar-->
