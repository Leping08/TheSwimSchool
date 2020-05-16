@component('mail::message')

<img alt="" style="margin-bottom: 2em;" src="{{asset('img/lessons/private.jpg')}}">

@component('mail::panel')
# Swim Season Starts this Monday 5/18!!
Hello from The Swim School! We are beyond excited to get back to the pool starting this Monday, May 18th now that it has been deemed safe by our state officials! Swim Team tryouts are on hold for now but registration is open online through our website for group classes, private lessons and swim club (pre-season swim team training). Thankfully the majority of our programs already operate with less than 10 participants and the pool is located outdoors in a privately owned facility with minimal community exposure. However, we are putting some additional safety protocols in place and will be emailing specific details regarding our enhanced on site safety measures prior to our opening this Monday. We can’t wait to swim with you soon!
@endcomponent

@component('mail::button', ['url' => config('app.url').'?utm_source=newsletter&utm_medium=email&utm_campaign=summer_lesson_registration'])
    Sign Up
@endcomponent

Sincerely,<br>
The Swim School

<div style="padding: 1em 0em 0em 0em; font-size: x-small; color: #9BA2AB">If you are no longer interested in receiving emails from The Swim School, you can <a href="{{config('app.url')}}unsubscribe/{{{$emailAddress}}}">unsubscribe</a>.</div>
@endcomponent
