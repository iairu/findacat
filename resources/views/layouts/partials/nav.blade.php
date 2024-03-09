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
                <li><a href="{{ route('cats.test-mating') }}">🔀{{ __('cat.test_mating') }}</a></li>
            </ul>

            <!-- Branding Image -->
            <a class="navbar-brand non-collapsed-only" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                <?php $mark = (preg_match('/\?/', url()->current())) ? '&' : '?';?>
                    <li><a href="{{ route('register') }}">🆕{{ __('app.register-a-cat') }}</a></li>
                    <li><a href="{{ route('backups.index') }}">🎞️{{ __('app.backups') }}</a></li>
                    <!-- <li><a href="{{ route('authorize') }}">👤{{ __('app.authorize') }}</a></li> -->
            </ul>
        </div>
    </div>
</nav>