<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('seo')
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- uikit stuff -->
    <link rel='stylesheet' id='theme-style-css'  href='http://theswimschool.deltavcreative.com/wp-content/themes/yootheme/css/theme.css?ver=1499371170' type='text/css' media='all' />
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
    
    @include('nav')


    <div uk-height-viewport="offset-top: true; offset-bottom: true">
        @if(Request::is('/'))

        @else
            <div class="uk-section-secondary uk-section-overlap uk-section" uk-scrollspy="{&quot;target&quot;:&quot;[uk-scrollspy-class]&quot;,&quot;cls&quot;:&quot;uk-animation-slide-top-medium&quot;,&quot;delay&quot;:false}">
                <div class="uk-container">
                    <div class="uk-grid-margin uk-grid uk-grid-stack" uk-grid="">
                        <div class="uk-width-1-1@m uk-first-column">
                            <h1 class="uk-text-center uk-scrollspy-inview uk-animation-slide-top-medium" uk-scrollspy-class="">
                                @yield('heading')
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @include('flash-message')

        @yield('content')

        @include('footer')

    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- Font Awesome CDN -->
    <script src="https://use.fontawesome.com/2df15bc632.js"></script>
    <!-- Uikit -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.25/js/uikit.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.25/js/uikit-icons.min.js"></script>
</body>
</html>
