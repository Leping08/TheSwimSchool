<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!--Bootstrap 4 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    
    <!--uikit stuff
    <link rel='stylesheet' id='theme-style-css'  href='http://theswimschool.deltavcreative.com/wp-content/themes/yootheme/css/theme.css?ver=1499203633' type='text/css' media='all' />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.25/js/uikit.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.25/js/uikit-icons.min.js"></script>
    -->

    <script src="https://js.stripe.com/v3/"></script>

    <script>
        var Laracasts = {
            csrfToken: "{{ csrf_token() }}",
            stripeKey: "{{ config('services.stripe.key') }}"
        };
    </script>
</head>
<body>
    <div class="mb-10">
        <nav class="navbar navbar-toggleable-md bg-faded navbar-inverse bg-primary">
            <!-- Collapsed Hamburger -->
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="container">
                <a class="navbar-brand" href="/lessons">
                    <img src="/images/TSST_png.png" width="40" height="40" alt="" class="mr-2">The Swim School</a>

                <div class="collapse navbar-collapse" id="navbarTogglerDemo01">

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                    </ul>
                    <ul class="navbar-nav">
                        <li {{{ (Request::is('lessons') ? 'class=active nav-item' : 'nav-item') }}}><a class="nav-link" href="/lessons"><i class="fa fa-tint" aria-hidden="true"></i> Lessons</a></li>
                        <!--<li {{{ (Request::is('calendar') ? 'class=active nav-item' : 'nav-item') }}}><a class="nav-link" href="/calendar"><i class="fa fa-calendar" aria-hidden="true"></i> Calendar</a></li>-->


                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <!--<li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>-->
                        @else
                        <li {{{ (Request::is('swimmers') ? 'class=active nav-item' : 'nav-item') }}}><a class="nav-link" href="/swimmers"><i class="fa fa-users" aria-hidden="true"></i> Swimmers</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-user" aria-hidden="true"></i> {{ Auth::user()->name }} <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        @include('flash-message')
        
        @yield('content')
    </div>


    <footer class="footer bg-primary text-white">
        <div class="container">
            <p>Website developed by DeltaV Creative.</p>
        </div>
    </footer>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- Font Awesome CDN -->
    <script src="https://use.fontawesome.com/2df15bc632.js"></script>
    <!--Bootstrap-->
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
</body>
</html>
