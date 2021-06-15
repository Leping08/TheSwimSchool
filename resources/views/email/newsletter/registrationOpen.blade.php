@component('mail::message')

<img alt="" style="margin-bottom: 2em;" src="{{asset('img/lessons/kids-floating.jpg')}}">

@component('mail::panel')
# Weekday Group & Private Lesson Registration Open!
Registration is now open for our next summer weekday session of group swim lessons as well as some additional private lesson time slots for the month of June with our new instructor, Colleen Allison. All swim lesson classes now take place at our new indoor pool location, Realhab Physical Therapy, Aquatics & Wellness Center. If you are currently enrolled in our group classes and have any questions regarding which level to sign your child up for in the next session, please consult with your instructor.
@endcomponent

@component('mail::button', ['url' => route('home.index').'?utm_source=newsletter&utm_medium=email&utm_campaign=summer_lesson_registration'])
Sign Up
@endcomponent

Sincerely,<br>
The Swim School

<div style="padding: 1em 0em 0em 0em; font-size: x-small; color: #9BA2AB">If you are no longer interested in receiving emails from The Swim School, you can <a href="{{route('newsletter.unsubscribe', ['email' => $emailAddress])}}">unsubscribe</a>.</div>
@endcomponent
