  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

      <div class="d-flex align-items-center justify-content-between">
          <a href="{{ route('dashboard') }}" class="logo d-flex align-items-center">
              @if (auth()->user()->hasRole('client'))
                  @php
                      $user = Helper::Clients();
                  @endphp
                  <img src="{{ asset('public/storage/clientlogo/' . $user->logo) }}" alt="">
              @endif
              @if (!empty(Helper::Users()))
                  <span class="d-none d-lg-block">{{ Helper::Users()->name }}</span>
              @endif
          </a>
          <i class="bi bi-list toggle-sidebar-btn"></i>
      </div><!-- End Logo -->



      <nav class="header-nav ms-auto">
          <ul class="d-flex align-items-center">
              <li class="nav-item dropdown pe-3">

                  <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#"
                      data-bs-toggle="dropdown">
                      @if (auth()->user()->hasRole('client'))
                          @php
                              $user = Helper::Clients();
                          @endphp
                          <img src="{{ asset('public/storage/clientlogo/' . $user->logo) }}" alt="Profile"
                              class="rounded-circle">
                      @endif
                      <span class="d-none d-md-block dropdown-toggle ps-2">{{ auth()->user()->name }}</span>
                  </a><!-- End Profile Iamge Icon -->

                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                      <li class="dropdown-header">
                          <h6>{{ auth()->user()->name }}</h6>
                          {{-- <span>Web Designer</span> --}}
                      </li>
                      <li>
                          <hr class="dropdown-divider">
                      </li>

                      <li>
                          <a class="dropdown-item d-flex align-items-center" href="{{ route('profile.edit') }}">
                              <i class="bi bi-gear"></i>
                              <span>Account Settings</span>
                          </a>
                      </li>
                      <li>
                          <hr class="dropdown-divider">
                      </li>

                      <li>
                          <form method="POST" action="{{ route('logout') }}">
                              @csrf
                              <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}"
                                  onclick="event.preventDefault();
                              this.closest('form').submit();">
                                  <i class="bi bi-box-arrow-right"></i>
                                  <span>Sign Out</span>
                              </a>
                          </form>
                      </li>

                  </ul><!-- End Profile Dropdown Items -->
              </li><!-- End Profile Nav -->

          </ul>
      </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->
