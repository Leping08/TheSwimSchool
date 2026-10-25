<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta name="google-site-verification" content="4fIxgM3FpiEuL2aezHa8v-opfhoObkjdfEzFmKtVg9U" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=PT+Serif:100,200,300,400,500,600,700,800,900|Raleway:100,200,300,400,500,600,700,800,900" rel="stylesheet">

    @include('gtm.script')

    <!-- SEO -->
    @yield('seo')

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Styles & Scripts -->
    @vite(['resources/assets/sass/app.scss', 'resources/assets/js/app.js'])
    <!-- Uikit JS -->
    <script src="{{asset('js/uikit.js')}}"></script>
    <script src="{{asset('js/uikit-icons.js')}}"></script>
    <script>
        window.laravelConfig = @json(['STRIPE_PUBLIC' => config('services.stripe.key')]);
    </script>
</head>
<body>
    @include('gtm.iframe')

    @include('nav')

    <div id="app" uk-height-viewport="offset-top: true; offset-bottom: true">
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

    <!-- Font Awesome CDN -->
    <script src="https://use.fontawesome.com/2df15bc632.js"></script>
</body>
</html>
