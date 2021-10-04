@component('mail::message')

<img alt="" style="margin-bottom: 2em;" src="{{ asset('img/thank-you/kicking.jpg') }}">

@component('mail::panel')
# Weekday Group Swim Lessons & Swim Club Open for Registration!
Registration is now open for our next weekday sessions of group lessons and swim club. If you are currently enrolled in our group classes and have any questions regarding which level to sign your child up for in the next session, please consult with your instructor.
@endcomponent

@component('mail::button', ['url' => route('groups.lessons.index').'?utm_source=newsletter&utm_medium=email&utm_campaign=summer_lesson_registration'])
Sign Up
@endcomponent

Sincerely,<br>
The Swim School

<div style="padding: 1em 0em 0em 0em; font-size: x-small; color: #9BA2AB">If you are no longer interested in receiving emails from The Swim School, you can <a href="{{route('newsletter.unsubscribe', ['email' => $emailAddress])}}">unsubscribe</a>.</div>
@endcomponent
