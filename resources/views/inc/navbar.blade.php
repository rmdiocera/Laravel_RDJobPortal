<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand title-font" href="{{ url('/') }}">
            {{ config('app.name', 'WorkForce') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            {{-- <ul class="navbar-nav mr-auto">

            </ul> --}}

            @if (Auth::guard('web')->check())
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/job-search">Job Search</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/active-applications">View Active Applications</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/saved-job-posts">Saved Job Posts</a>
                    </li>
                </ul>
            @elseif (Auth::guard('employer')->check())
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/job-posts">View Job Posts</a>
                    </li>    
                </ul>
            @else
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/job-search">Job Search</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/about">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/contact-us">Contact Us</a>
                    </li>
                </ul>
            @endif

            {{-- @auth('employer')
                @if (Auth::guard('employer')->check())
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="/job-posts">View Job Posts</a>
                        </li>
                    </ul>
                @endif
            @endauth --}}

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                
                @auth('web')
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->username }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a href="{{ route('user.dashboard') }}" class="dropdown-item">Dashboard</a>
                            <a href="{{ route('user.show_profile') }}" class="dropdown-item">Profile</a>
                            <a class="dropdown-item" href="{{ route('user.logout') }}"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endauth

                @auth('employer')
                    <li class="nav-item">
                        <a href="/create-job-post" class="nav-link">Create Job Post</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::guard('employer')->user()->username }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a href="{{ route('employer.dashboard') }}" class="dropdown-item">Dashboard</a>
                            <a href="{{ route('employer.show_profile') }}" class="dropdown-item">Profile</a>
                            <a class="dropdown-item" href="{{ route('employer.logout') }}"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('employer.logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endauth

                @guest
                    @if (Request::is('/') || Request::is('login') || Request::is('register') || Request::is('about') || Request::is('contact-us') || Request::is('job-search'))
                        <li class="nav-item">
                            <a href="{{route('employer.login')}}" class="nav-link">For Employers</a>
                        </li>    
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item">
                            <a href="{{route('login')}}" class="nav-link">For Applicants</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('employer.login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('employer.register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @endif
                @endguest

                {{-- @guest
                    @if (Request::is('/') || Request::is('login'))
                        <li class="nav-item">
                            <a href="{{route('employer.login')}}" class="nav-link">For Employers</a>
                        </li>    
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item">
                            <a href="{{route('login')}}" class="nav-link">For Applicants</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('employer.login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('employer.register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @endif
                @else
                @if ((Auth::guard('web')->check()) && (Request::is('employer/login')))    
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('employer.login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('employer.register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    @if ((Auth::guard('employer')->check()) && (Request::is('employer/*') || Request::is('employer')))
                    <li class="nav-item">
                        <a href="/create-job-post" class="nav-link">Create Job Post</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->username }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a href="{{ route('employer.show_profile') }}" class="dropdown-item">Profile</a>
                            <a class="dropdown-item" href="{{ route('employer.logout') }}"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('employer.logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->username }} <span class="caret"></span>
                            </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a href="{{ route('user.show_profile') }}" class="dropdown-item">Profile</a>
                            <a class="dropdown-item" href="{{ route('user.logout') }}"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                        @endif
                    </li>
                @endif
                    
                @endguest --}}
            </ul>
        </div>
    </div>
</nav>

