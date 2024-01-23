<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                <li><a href="{{ route('cats.search') }}">{{ __('app.search_your_family') }}</a></li>
                <li><a href="{{ route('birthdays.index') }}">{{ __('birthday.birthday') }}</a></li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                <?php $mark = (preg_match('/\?/', url()->current())) ? '&' : '?';?>
                    <li><a href="{{ route('register') }}">Register</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ route('backups.index') }}">{{ __('backup.list') }}</a></li>
                            <li><a href="{{ route('profile') }}">{{ __('app.my_profile') }}</a></li>
                            
                        </ul>
                    </li>
            </ul>
        </div>
    </div>
</nav>