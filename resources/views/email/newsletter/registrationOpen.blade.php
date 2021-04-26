@component('mail::message')

<img alt="" style="margin-bottom: 2em;" src="{{asset('img/lessons/sun.jpg')}}">

@component('mail::panel')
# May Weekday Group Lessons, Swim Club & Private Lessons Registration Now Open!
Registration is now open for our next weekday session of group swim lessons, our available private lessons for the month of May, and the Flying Fish and Shark swim club. As a reminder, the group and private swim lessons will now be held at our new indoor pool location, Realhab Physical Therapy, Aquatics & Wellness Center. The Flying Fish and Shark swim club will remain at our River Wilderness Golf & Country Club outdoor pool location. If you are currently enrolled in our group classes and have any questions regarding which level to sign your child up for in the next session, please consult with your instructor.
@endcomponent

@component('mail::button', ['url' => route('home.index').'?utm_source=newsletter&utm_medium=email&utm_campaign=summer_lesson_registration'])
Sign Up
@endcomponent

Sincerely,<br>
The Swim School

<div style="padding: 1em 0em 0em 0em; font-size: x-small; color: #9BA2AB">If you are no longer interested in receiving emails from The Swim School, you can <a href="{{route('newsletter.unsubscribe', ['email' => $emailAddress])}}">unsubscribe</a>.</div>
@endcomponent
