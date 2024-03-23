<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Branding Image -->
            <a class="navbar-brand collapsed-only" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                <li><a href="{{ route('cats.search') }}">🔎{{ __('app.search') }}</a></li>
                <li><a href="{{ route('birthdays.index') }}">🎂{{ __('app.birthdays') }}</a></li>
                <li><a href="/test/1/1">🔀{{ __('cat.test_mating') }}</a></li>
            </ul>

            <!-- Branding Image -->
            <a class="navbar-brand non-collapsed-only" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                <?php $mark = (preg_match('/\?/', url()->current())) ? '&' : '?';?>
                    @if (Auth::user() && Auth::user()->is_admin)
                    <li><a href="{{ route('register-cat') }}">🆕{{ __('app.register-a-cat') }}</a></li>
                    <li><a href="{{ route('backups.index') }}">🎞️{{ __('app.backups') }}</a></li>
                    @endif
                    @if (Auth::guest())
                    <li><a href="{{ route('login') }}">👤{{ __('app.login') }}</a></li>
                    <li><a href="{{ route('register') }}">♥️{{ __('app.register') }}</a></li>
                    @else
                    <li>
                        <div>👤{{ Auth::user()->name }}</div>
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <a href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('app.logout') }}
                            </a>
                        </form>
                    </li>
                    @endif


            </ul>
        </div>
    </div>
</nav>