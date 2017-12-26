@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <img src="{{asset('/img/footer-logo.png')}}">
        @endcomponent
    @endslot

    {{-- Body --}}
    {{ $slot }}

    {{-- Subcopy --}}
    @isset($subcopy)
        @slot('subcopy')
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endisset

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            <div style="padding-top:10px; text-align:center !important;">
                <a href="https://www.facebook.com/DealersUnited/" target="blank"><img style="padding: 10px;" src="{{asset('/img/phone-in-talk.png')}}"></a>
                <a href="mailto:theswimschoolfl@gmail.com"><img style="padding: 10px;" src="{{asset('/img/email.png')}}"></a>
                <a href="https://www.facebook.com/theswimschoolfl/" target="blank"><img style="padding: 10px;" src="{{asset('/img/facebook-box.png')}}"></a>
            </div>

            <p>
                &copy; {{ date('Y') }} The Swim School. All rights reserved.<br>
            </p>
        @endcomponent
    @endslot
@endcomponent
