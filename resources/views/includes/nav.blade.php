<?php /* Header/Nav */ ?>
<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark mb-0">
    <?php /* Text "logo" */ ?>
    <a class="navbar-brand" href="{{ route('home') }}">CMR</a>

    <?php /* Mobile menu button */ ?>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <?php /* Menus: left and right */ ?>
    <div class="collapse navbar-collapse" id="navbarCollapse">

        @if(Auth::check())
            <?php /* Left (main) menu items: */ ?>
            <ul class="navbar-nav mr-auto">
                @canany(['organization index'])
                    <li class="nav-item @php if(isset($nav_path[0]) && $nav_path[0] == 'organizations') echo 'active'; @endphp">
                        <a class="nav-link" href="{{ route('applicant.index') }}">Applicants <span class="sr-only">(current)</span></a>
                    </li>
                @endif

                @canany(['statute index'])
                    <li class="nav-item @php if(isset($nav_path[0]) && $nav_path[0] == 'statute') echo 'active'; @endphp">
                        <a class="nav-link" href="{{ route('statute.index') }}">Statutes <span class="sr-only">(current)</span></a>
                    </li>
                @endif

                <li class="nav-item dropdown @php if(isset($nav_path[0]) && $nav_path[0] == 'admin') echo 'active'; @endphp">
                    <a class="nav-link dropdown-toggle" href="#TODO" id="dropdown-admin" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">Admin</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown-admin">
                        @canany(['invite index'])
                            <a class="dropdown-item @php if(isset($nav_path[1]) && $nav_path[1] == 'invite') echo 'active'; @endphp"
                               href="/invite">Invite Users</a>
                        @endcanany
                        @canany(['status index'])
                            <a class="dropdown-item @php if(isset($nav_path[1]) && $nav_path[1] == 'status') echo 'active'; @endphp"
                               href="/status">Applicant Statuses</a>
                        @endcanany
                    </div>
                </li>

            </ul>

            <?php /* Right (auxiliary) menu items: */ ?>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown @php if(isset($nav_path[0]) && $nav_path[0] == 'meta') echo 'active'; @endphp">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="dropdown-current-user"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Welcome, {{ Auth::user()->name }}!
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdown-current-user">
                        <a class="dropdown-item @php if(isset($nav_path[1]) && $nav_path[1] == 'change-password') echo 'active'; @endphp"
                           href="/change-password">Change Password</a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                    </div>
                </li>
            </ul>

            <?php /* Apparently Laravel does logout route via post; get not accepted */ ?>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                {{ csrf_field() }}
                {{ method_field('POST') }}
            </form>
        @else
            <?php /* Right (auxiliary) menu items: */ ?>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item @php if(isset($nav_path[0]) && $nav_path[0] == 'login') echo 'active'; @endphp">
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                </li>
            </ul>
        @endif

    </div>
</nav>
