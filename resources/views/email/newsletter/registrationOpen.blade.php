@component('mail::message')

<img alt="" style="margin-bottom: 2em;" src="{{ asset('img/thank-you/bennett.jpg') }}">

@component('mail::panel')
# September Swim Programs Open for Registration!
Registration is now open for our September private swim lessons, swim club, and weekday & weekend group lesson sessions. If you are currently enrolled in our group classes and have any questions regarding which level to sign your child up for in the next session, please consult with your instructor.
@endcomponent

@component('mail::button', ['url' => route('home.index').'?utm_source=newsletter&utm_medium=email&utm_campaign=summer_lesson_registration'])
Sign Up
@endcomponent

Sincerely,<br>
The Swim School

<div style="padding: 1em 0em 0em 0em; font-size: x-small; color: #9BA2AB">If you are no longer interested in receiving emails from The Swim School, you can <a href="{{route('newsletter.unsubscribe', ['email' => $emailAddress])}}">unsubscribe</a>.</div>
@endcomponent
