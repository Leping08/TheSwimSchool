@component('mail::message')

<img style="margin-bottom: 2em;" src="{{asset('img/thank-you/smile.jpg')}}">

@component('mail::panel')
# Lesson Registration Opens Feb 11th
Dust off your goggles and stock up on sunscreen, it’s time to get excited about our upcoming 2019 swim season! The Swim School will be starting programs the first week of March and registration opens online through our website this Monday, February 11th. We are looking forward to seeing you at the pool very soon!
@endcomponent

@component('mail::button', ['url' => config('app.url').'?utm_source=newsletter&utm_medium=email&utm_campaign=spring_lesson_registration'])
    Sign Up
@endcomponent

Sincerely,<br>
The Swim School

<div style="padding: 1em 0em 0em 0em; font-size: x-small; color: #9BA2AB">If you are no longer interested in receiving emails from The Swim School, you can <a href="{{config('app.url')}}unsubscribe/{{{$emailAddress}}}">unsubscribe</a>.</div>
@endcomponent
