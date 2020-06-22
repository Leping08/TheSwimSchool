@component('mail::message')

<img alt="" style="margin-bottom: 2em;" src="{{asset('img/thank-you/bennett.jpg')}}">

@component('mail::panel')
# Weekday Lesson Registration Open
Registration is now open for our next weekday session of group swim lessons and swim club. If you are currently enrolled and have any questions regarding which level to sign your child up for in the next session, please consult with your instructor.
@endcomponent

@component('mail::button', ['url' => config('app.url').'?utm_source=newsletter&utm_medium=email&utm_campaign=summer_lesson_registration'])
    Sign Up
@endcomponent

Sincerely,<br>
The Swim School

<div style="padding: 1em 0em 0em 0em; font-size: x-small; color: #9BA2AB">If you are no longer interested in receiving emails from The Swim School, you can <a href="{{config('app.url')}}unsubscribe/{{{$emailAddress}}}">unsubscribe</a>.</div>
@endcomponent
