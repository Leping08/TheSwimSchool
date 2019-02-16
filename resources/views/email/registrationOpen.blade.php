@component('mail::message')

<img style="margin-bottom: 2em;" src="{{asset('img/thank-you/float.jpg')}}">

@component('mail::panel')
# Registration is Now Open
Calling all fish! We are now accepting registrations for our 2019 swim season. We have group classes, private lessons, and pre-season swim team training options available starting in March. If you’d like to get enrolled, check out our website for more details. If you’ve already signed up, we can’t wait to see you back in the pool soon!
@endcomponent

@component('mail::button', ['url' => 'https://theswimschoolfl.com/?utm_source=newsletter&utm_medium=email&utm_campaign=spring_lesson_registration'])
    Sign Up
@endcomponent

Sincerely,<br>
The Swim School

<div style="padding: 1em 0em 0em 0em; font-size: x-small; color: #9BA2AB">If you are no longer interested in receiving emails from The Swim School, you can <a href="theswimschoolfl.com/unsubscribe/{{{$emailAddress}}}">unsubscribe</a>.</div>
@endcomponent
