@component('mail::message')

<img alt="" style="margin-bottom: 2em;" src="{{asset('img/thank-you/breast-stroke.jpg')}}">

@component('mail::panel')
# Final Weekday Session of Swim Club Registration Open Now
Registration is now open for our final weekday session of Dolphin, Flying Fish and Shark swim club for the 2020 season. This will be a Mon/Wed/Fri session starting on Monday 10/12 and ending on Wednesday 10/28.
@endcomponent

@component('mail::button', ['url' => route('groups.lessons.index').'?utm_source=newsletter&utm_medium=email&utm_campaign=summer_lesson_registration'])
    Sign Up
@endcomponent

Sincerely,<br>
The Swim School

<div style="padding: 1em 0em 0em 0em; font-size: x-small; color: #9BA2AB">If you are no longer interested in receiving emails from The Swim School, you can <a href="{{route('newsletter.unsubscribe', ['email' => $emailAddress])}}">unsubscribe</a>.</div>
@endcomponent
