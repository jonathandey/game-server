@inject('game', 'App\Game\Game')
@php
    $notificationsCount = $game->player()->unreadNotifications()->count();
@endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $game->name() }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
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
                        {{ $game->name() }}
                    </a>
                    <div class="hidden-md hidden-lg">
                        <p class="navbar-text">
                            <a href="/notifications">
                                @if ($notificationsCount > 0)
                                    <i class="fa fa-bell" aria-hidden="true"></i>
                                    <span class="badge badge-danger">
                                        {{ $notificationsCount }}
                                    </span>
                                @else
                                    <i class="fa fa-bell-o" aria-hidden="true"></i>
                                @endif
                            </a>
                        </p>
                    </div>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        <li>
                            <a>
                            	<strong>Cash:</strong> {{ $game->player()->presenter()->moneyWithSymbol() }}
                            </a>
                        </li>
                        <li>
                            <a>
                            	<strong>Crime Skill:</strong> {{ $game->player()->attribute->crime_skill }}
                            </a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="hidden-xs hidden-sm">
                                <a href="/notifications">
                                    @if ($notificationsCount > 0)
                                        <i class="fa fa-bell" aria-hidden="true"></i>
                                        <span class="badge badge-danger">
                                            {{ $notificationsCount }}
                                        </span>
                                    @else
                                        <i class="fa fa-bell-o" aria-hidden="true"></i>
                                    @endif
                                </a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <ul class="nav nav-justified">
                            <li>
                                Timers:
                            </li>
                            <li>
                                <a href="/crimes" class="timer">
                                    <strong>Crime:</strong>
                                    <span class="countdown">
                                        @timer($game->player()->timer->for('crime'))
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="/autoburglary" class="timer">
                                    <strong>Auto Burglary:</strong> 
                                    <span class="countdown">
                                        @timer($game->player()->timer->for('auto_burglary'))
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="/gym" class="timer">
                                    <strong>Gym</strong> 
                                    <span class="countdown">
                                        @timer($game->player()->timer->for('gym'))
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <div class="container-fluid">
        	<div class="row">
        		<div class="col-md-2">
        			@include('game.sections.menus.game')
        		</div>
        		<div class="col-md-9 col-md-offset-1">
        			@yield('content')
        		</div>
        	</div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/basic.js') }}"></script>
</body>
</html>
