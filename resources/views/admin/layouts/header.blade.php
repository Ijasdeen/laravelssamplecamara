  <!--  BEGIN NAVBAR  -->
  <div class="header-container fixed-top">
    <header class="header navbar navbar-expand-sm">

        <ul class="navbar-item theme-brand flex-row  text-center">
            <li class="nav-item theme-logo">
                <a href="{{ url('/') }}">
                   <img src="{{ auth()->user()->user_image ? url('/') . '/' . auth()->user()->user_image : asset('assets/img/boy.png') }}" class="navbar-logo" alt="logo"> 
<!--  <img src="{{ asset('assets/images/logo_2.png') }}" alt="" style="width: fit-content;"> -->	
                </a>
            </li>
            <li class="nav-item theme-text">
                <a href="{{ url('/') }}" class="nav-link" style="font-family: Kontanter;">Camara Qatar</a>
            </li>
        </ul>

        <ul class="navbar-item flex-row ml-auto">

            <li class="nav-item dropdown user-profile-dropdown">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">

                    <img src="{{ (auth()->user()->user_image) ? url('/') . '/' . auth()->user()->user_image : asset('assets/img/boy.png') }}" alt="avatar">
                </a>
                <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
                    <div class="">
                        <div class="dropdown-item">
                            <a class="" href="{{ route('admin.update_profile') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-user">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg> 
                                My profile
                            </a>
                        </div>

                        <div class="dropdown-item">
                            <a class="" href="{{ route('admin.change_password') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-lock">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                                </svg>
                                Change password
                            </a>
                        </div>

                        <div class="dropdown-item">
                            <a class="" href="{{ route('logout') }} role=" button"
                                onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <svg xmlns=" http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-log-out">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" y1="12" x2="9" y2="12"></line>
                                </svg>
                                Sign out
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>

                        </div>
                    </div>
                </div>
            </li>

        </ul>
    </header>
</div>
<!--  END NAVBAR  -->