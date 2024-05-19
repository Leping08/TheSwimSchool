@component('mail::layout')

@slot('header')
@component('mail::header', ['url' => route('swim-team.index')])
<img alt="" style="max-width: 300px;" src="{{asset('img/logos/parrish-bull-sharks.png')}}">
@endcomponent
@endslot

# {{ config('swim-team.full-name') }} Awards Dinner

@component('mail::panel')
<img alt="" style="max-width: 100%;" src="{{asset('img/swim-team/RSVP2.jpg')}}">
@endcomponent

@component('mail::panel')
Please RSVP for our team awards dinner no later than Thursday, August 18th using the form below.
@endcomponent

@component('mail::button', ['url' => 'https://docs.google.com/forms/d/e/1FAIpQLScL-VjdnGorWjgjF2_rptuPvpi8_vUu9-zVKIvy_1CiJXB5bw/viewform'])
RSVP Here
@endcomponent

Thanks,<br>
{{ config('swim-team.name') }}

@slot('footer')
@component('mail::footer')

@include('email.components.swim-team.footer')

@endcomponent
@endslot

@endcomponent
