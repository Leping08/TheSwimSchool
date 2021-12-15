@component('mail::message')

<img alt="" style="margin-bottom: 2em;" src="{{ asset('img/lessons/kids-floating.jpg') }}">

@component('mail::panel')
# 2022 Winter/Spring Group Swim Lesson Session Schedule Now Available!
Our 2022 Winter & Spring Group Swim Lesson Session Schedule is now available on our website and includes the registration dates for each session. The first weekday session of the new year opens for registration Monday, January 3rd while the first weekend session opens for registration Monday, January 10th. Private swim lessons for the month of January will be open for registration on Wednesday, December 25th. We wish you all a wonderful holiday season and Happy New Year!
@endcomponent

@component('mail::button', ['url' => route('groups.schedule.index').'?utm_source=newsletter&utm_medium=email&utm_campaign=summer_lesson_registration'])
View Schedule
@endcomponent

{{-- @component('mail::panel')
# November Private Lessons, Final Group Session of 2021, and New Instructor!
Registration is now open for our available private swim lessons for the month of November and our final weekday session of group classes & swim club for the year. If you are currently enrolled in our group classes and have any questions regarding which level to sign your child up for in the next session, please consult with your instructor.
@endcomponent --}}

{{-- @component('mail::button', ['url' => route('groups.lessons.index').'?utm_source=newsletter&utm_medium=email&utm_campaign=summer_lesson_registration'])
Sign Up
@endcomponent --}}

Sincerely,<br>
The Swim School

<div style="padding: 1em 0em 0em 0em; font-size: x-small; color: #9BA2AB">If you are no longer interested in receiving emails from The Swim School, you can <a href="{{route('newsletter.unsubscribe', ['email' => $emailAddress])}}">unsubscribe</a>.</div>
@endcomponent
