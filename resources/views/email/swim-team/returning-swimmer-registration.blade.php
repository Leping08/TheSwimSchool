@component('mail::layout')

@slot('header')
@component('mail::header', ['url' => route('swim-team.index')])
<img alt="" style="max-width: 300px;" src="{{asset('img/logos/parrish-bull-sharks.png')}}">
@endcomponent
@endslot

# Returning Swimmer Registration

@component('mail::panel')
<img alt="" style="max-width: 100%;" src="{{asset('img/swim-team/backstroke.jpg')}}">
@endcomponent

@component('mail::panel')
Hey {{ $swimmer->firstName }},

We're excited to have you back on the team! To secure your spot, there is a $50 registration fee per rejoining swimmer due prior to attending your first swim practice.

A recurring monthly fee will be applied on the first of the next month based on your assigned practice level within the program.

For information on the current swim practice schedule for your assigned practice level and the swim meet schedule, please refer to the swim team page of the website.

Please email <a href="mailto:{{config('swim-team.email')}}">{{config('swim-team.email')}}</a> or call <a href="tel:+1{{config('contact.phone.number')}}">{{ config('contact.phone.number') }}</a> with any questions. Let's go Bull Sharks! Chomp, Chomp, Chomp!
@endcomponent

@component('mail::button', ['url' => route('swim-team.swimmer.register', ['swimmer' => $swimmer, 'level' => $swimmer->level])])
Returning Swimmer Registration
@endcomponent

See you at the pool!<br>
{{ config('swim-team.name') }}

@slot('footer')
@component('mail::footer')

@include('email.components.swim-team.footer')

@endcomponent
@endslot

@endcomponent
