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

            <p>
                <!-- TODO: add Facebook, phone, email icons with links -->
                &copy; {{ date('Y') }} The Swim School. All rights reserved.<br>
            </p>
        @endcomponent
    @endslot
@endcomponent
