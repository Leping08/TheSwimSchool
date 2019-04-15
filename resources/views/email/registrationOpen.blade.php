@component('mail::message')

<img style="margin-bottom: 2em;" src="{{asset('img/thank-you/kicking.jpg')}}">

@component('mail::panel')
# Registration is Now Open
Registration is now open for our April weekday sessions of group swim lessons and swim club. If you are currently enrolled and have any questions regarding which level to sign your child up for in the next session, please consult with your instructor.
@endcomponent

@component('mail::button', ['url' => 'https://theswimschoolfl.com/?utm_source=newsletter&utm_medium=email&utm_campaign=spring_lesson_registration'])
    Sign Up
@endcomponent

Sincerely,<br>
The Swim School

<div style="padding: 1em 0em 0em 0em; font-size: x-small; color: #9BA2AB">If you are no longer interested in receiving emails from The Swim School, you can <a href="theswimschoolfl.com/unsubscribe/{{{$emailAddress}}}">unsubscribe</a>.</div>
@endcomponent