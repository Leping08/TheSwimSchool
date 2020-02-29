<div class="tm-header-mobile uk-hidden@m">
    <nav class="uk-navbar-container" uk-navbar>
        <div class="uk-navbar-left">
            <a title="Parrish Swimming Lessons" class="uk-navbar-item uk-logo" href="{{ route('home.index') }}">
                <img src="/img/logos/the-swim-school.png" style="max-width: 60%;" class="uk-responsive-height" alt="Lakewood Ranch Swim Lessons">
            </a>
        </div>
        <div class="uk-navbar-right">
            <a class="uk-navbar-toggle" href="#tm-mobile" uk-toggle>
                <span uk-icon="icon: menu; ratio: 2"></span>
            </a>
        </div>
    </nav>
    <div id="tm-mobile" uk-offcanvas="overlay: true; flip: true;">
        <div class="uk-offcanvas-bar">
            <button class="uk-offcanvas-close" type="button" uk-close></button>
            <div class="uk-child-width-1-1" uk-grid>
                <div>
                    <div class="uk-panel">
                        <ul class="uk-nav uk-nav-default">
                            <li class="{{{ (Request::is('/') ? 'uk-active' : null ) }}}"><a href="{{ route('home.index') }}">Home</a></li>
                            <li class="{{{ (Request::segment(1) === 'lessons' || Request::segment(1) === 'private-semi-private' ||  Request::segment(1) === 'swim-team' ||  Request::segment(1) === 'other-services'  ? 'uk-active' : null) }}} uk-parent">
                                <a>Services</a>
                                <ul class="uk-nav-sub">
                                    <li class="{{{ (Request::segment(1) === 'lessons' ? 'uk-active' : null) }}} "><a title="Manatee County Swimming Classes" href="{{ route('groups.lessons.index') }}">Group Lessons</a></li>
                                    <li class="{{{ (Request::segment(1) === 'private-semi-private' ? 'uk-active' : null) }}} "><a title="Parrish Private Swim Lessons" href="{{ route('privates.index') }}">Private Lessons</a></li>
                                    <li class="{{{ (Request::segment(1) === 'swim-team' ? 'uk-active' : null) }}} "><a title="Palmetto Swim Team" href="{{ route('swim-team.index') }}">Swim Team</a></li>
                                </ul>
                            </li>
                            <li class="{{{ (Request::segment(1) === 'about' ? 'uk-active' : null) }}} "><a title="Parrish Learn to Swim" href="{{ route('pages.about') }}">About</a></li>
                            <li class="{{{ (Request::segment(1) === 'contact-us' ? 'uk-active' : null) }}} "><a title="Lakewood Ranch Swim Instructors" href="{{ route('pages.contact-us') }}">Contact Us</a></li>
                        </ul>
                    </div>
                </div>
                <hr>
                @if (Auth::guest())

                @else

                <div class="uk-panel">
                    <ul class="uk-nav uk-nav-default">
                        <li class="uk-parent">
                            <a href="#"> {{ Auth::user()->name }}</a>
                            <div class="uk-nav uk-nav-default">
                                <ul class="uk-nav-sub">
                                    <li><a href="/admin"><i class="fa fa-th-large fa-lg" aria-hidden="true"></i> Dashboard</a></li>
                                    <li><a href="https://datastudio.google.com/open/17dj-YhyTBpc5Rev_w3puKIfPKBALD6oL" target="_blank"><i class="fa fa-area-chart fa-lg" aria-hidden="true"></i> Analytics</a></li>
                                    <li><a href="/admin/resources/swimmers"><i class="fa fa-users fa-lg" aria-hidden="true"></i> Swimmers</a></li>
                                    <li><a href="/admin/resources/lessons"><i class="fa fa-tint fa-lg" aria-hidden="true"></i> Lessons</a></li>
                                    <li><a href="https://stripe.com/" target="_blank"><i class="fa fa-money fa-lg" aria-hidden="true"></i> Stripe</a></li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fa fa-sign-out fa-lg" aria-hidden="true"></i> Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
                <hr>
                @endif
                <div>
                    <div class="uk-panel widget-text uk-margin-top" id="widget-text-8">
                        <div class="textwidget"><a href="tel:941-773-1424"><button class="uk-button uk-button-primary uk-width-1-1 uk-margin-small-bottom">Call</button></a>
                            <a href="mailto:theswimschoolfl@gmail.com"><button class="uk-button uk-button-primary uk-width-1-1 uk-margin-small-bottom">Email</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="tm-header uk-visible@m">
    <div class="uk-navbar-container" uk-sticky cls-active="uk-active uk-navbar-sticky">
        <div class="uk-container uk-container-expand">
            <nav class="uk-navbar" uk-navbar>
                <div class="uk-navbar-left">
                    <a class="uk-navbar-item uk-logo" href="{{ route('home.index') }}">
                        <img src="/img/logos/the-swim-school.png" class="uk-responsive-height" style="max-width: 60%;" alt="Bradenton Swim Lessons">
                    </a>
                </div>
                <div class="uk-navbar-center">
                    <ul class="uk-navbar-nav">
                        <li class="{{{ (Request::is('/') ? 'uk-active' : null ) }}}"><a href="{{ route('home.index') }}">Home</a></li>
                        <li class="{{{ (Request::segment(1) === 'lessons' || Request::segment(1) === 'private-semi-private' ||  Request::segment(1) === 'swim-team' ||  Request::segment(1) === 'other-services'  ? 'uk-active' : null) }}} uk-parent">
                            <a>Services</a>
                            <div class="uk-navbar-dropdown">
                                <div class="uk-navbar-dropdown-grid uk-child-width-1-1" uk-grid>
                                    <div>
                                        <ul class="uk-nav uk-navbar-dropdown-nav">
                                            <li class="{{{ (Request::segment(1) === 'lessons' ? 'uk-active' : null) }}} "><a title="Manatee County Swimming Classes" href="{{ route('groups.lessons.index') }}">Group Lessons</a></li>
                                            <li class="{{{ (Request::segment(1) === 'private-semi-private' ? 'uk-active' : null) }}} "><a title="Parrish Private Swim Lessons" href="{{ route('privates.index') }}">Private Lessons</a></li>
                                            <li class="{{{ (Request::segment(1) === 'swim-team' ? 'uk-active' : null) }}} "><a title="Palmetto Swim Team" href="{{ route('swim-team.index') }}">Swim Team</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="{{{ (Request::segment(1) === 'about' ? 'uk-active' : null) }}} "><a title="Parrish Learn to Swim" href="{{ route('pages.about') }}">About</a></li>
                        <li class="{{{ (Request::segment(1) === 'contact-us' ? 'uk-active' : null) }}} "><a title="Lakewood Ranch Swim Instructors" href="{{ route('pages.contact-us') }}">Contact Us</a></li>
                    </ul>
                </div>
                <div class="uk-navbar-right">
                    @if (Auth::guest())

                    @else
                    <ul class="uk-navbar-nav">
                        <li>
                            <a href="#"> {{ Auth::user()->name }} <span uk-icon="icon: triangle-down"></span></a>
                            <div class="uk-navbar-dropdown">
                                <ul class="uk-nav uk-navbar-dropdown-nav">
                                    <li><a href="/admin"><i class="fa fa-th-large fa-lg" aria-hidden="true"></i> Dashboard</a></li>
                                    <li><a href="https://datastudio.google.com/open/17dj-YhyTBpc5Rev_w3puKIfPKBALD6oL" target="_blank"><i class="fa fa-area-chart fa-lg" aria-hidden="true"></i> Analytics</a></li>
                                    <li><a href="/admin/resources/swimmers"><i class="fa fa-users fa-lg" aria-hidden="true"></i> Swimmers</a></li>
                                    <li><a href="/admin/resources/lessons"><i class="fa fa-tint fa-lg" aria-hidden="true"></i> Lessons</a></li>
                                    <li><a href="https://stripe.com/" target="_blank"><i class="fa fa-money fa-lg" aria-hidden="true"></i> Stripe</a></li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fa fa-sign-out fa-lg" aria-hidden="true"></i> Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                    @endif
                    <div class="uk-navbar-item">
                        <ul class="uk-grid-small uk-flex-inline uk-flex-middle uk-flex-nowrap" uk-grid>
                            <li>
                                <a title="The Swim School Facebook" href="https://www.facebook.com/theswimschoolfl/" class="uk-icon-button" target="_blank" uk-icon="facebook"></a>
                            </li>
                            <li>
                                <a title="The Swim School Instagram" href="https://www.instagram.com/theswimschoolfl/" class="uk-icon-button" target="_blank" uk-icon="instagram"></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
