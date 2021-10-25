@component('mail::message')

<img alt="" style="margin-bottom: 2em;" src="{{ asset('img/lessons/kids-floating.jpg') }}">

@component('mail::panel')
# November Private Lessons, Final Group Session of 2021, and New Instructor!
Registration is now open for our available private swim lessons for the month of November and our final weekday session of group classes & swim club for the year. If you are currently enrolled in our group classes and have any questions regarding which level to sign your child up for in the next session, please consult with your instructor.
@endcomponent


@component('mail::panel')
We are also extremely excited to officially announce a new addition to our team! Miss Jacie Dyer will now be teaching group classes and private lessons as well as assisting with the swim club from time to time. You can learn more about Miss Jacie <a target="_blank" href="{{route('pages.about').'#Jacie'}}">here</a>.
@endcomponent

@component('mail::button', ['url' => route('groups.lessons.index').'?utm_source=newsletter&utm_medium=email&utm_campaign=summer_lesson_registration'])
Sign Up
@endcomponent

Sincerely,<br>
The Swim School

<div style="padding: 1em 0em 0em 0em; font-size: x-small; color: #9BA2AB">If you are no longer interested in receiving emails from The Swim School, you can <a href="{{route('newsletter.unsubscribe', ['email' => $emailAddress])}}">unsubscribe</a>.</div>
@endcomponent
