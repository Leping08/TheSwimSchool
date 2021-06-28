@component('mail::message')

<img alt="" style="margin-bottom: 2em;" src="{{asset('img/swim-team/backstroke.jpg')}}">

@component('mail::panel')
# Weekday Group & July Private Lesson Registration Is Now Open!
Registration is now open for our next weekday session of group swim lessons that starts Monday, July 5th as well as our available private swim lessons for the month of July with our new instructor, <a href="{{route('pages.about') . '#Colleen'}}">Colleen Allison</a>. If you are currently enrolled in our group classes and have any questions regarding which level to sign your child up for in the next session, please consult with your instructor.
@endcomponent

@component('mail::button', ['url' => route('home.index').'?utm_source=newsletter&utm_medium=email&utm_campaign=summer_lesson_registration'])
Sign Up
@endcomponent

Sincerely,<br>
The Swim School

<div style="padding: 1em 0em 0em 0em; font-size: x-small; color: #9BA2AB">If you are no longer interested in receiving emails from The Swim School, you can <a href="{{route('newsletter.unsubscribe', ['email' => $emailAddress])}}">unsubscribe</a>.</div>
@endcomponent
