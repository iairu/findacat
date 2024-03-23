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
                @auth
                <li><a href="/test/1/1">👤{{ __('app.dashboard') }}</a></li>
                @endauth
            </ul>

            <!-- Branding Image -->
            <a class="navbar-brand non-collapsed-only" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                <?php $mark = (preg_match('/\?/', url()->current())) ? '&' : '?';?>
                    @if (Auth::user())
                    <li><a href="{{ route('register-cat') }}">🆕{{ __('app.register-a-cat') }}</a></li>
                    @endif
                    <li><a href="{{ route('backups.index') }}">🎞️{{ __('app.backups') }}</a></li>
                    @if (Auth::guest())
                    <li><a href="{{ route('login') }}">👤{{ __('app.login') }}</a></li>
                    <li><a href="{{ route('register') }}">♥️{{ __('app.register') }}</a></li>
                    @else
                    <li>
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                    <div>👤{{ Auth::user()->name }}</div>

                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                        {{ __('app.logout') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </li>
                    @endif


            </ul>
        </div>
    </div>
</nav>