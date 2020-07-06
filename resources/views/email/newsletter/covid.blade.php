@component('mail::message')

<img alt="" style="margin-bottom: 2em;" src="{{asset('img/lessons/sun.jpg')}}">

@component('mail::panel')
# The Swim School Coronavirus (COVID-19) Response
The Swim School is reopening Monday, May 18th! Thankfully we will already be outdoors and entry to the pool is hands free through the open gate, but we have added a few new safety precautions in response to the Coronavirus pandemic. Please read the following attachment prior to attending your first day and help us with our mitigation efforts. We want everyone to feel safe, be safe and stay safe! If you have any additional recommendations, please contact me directly at
<a href="tel:+19417731424">941-773-1424</a>.
@endcomponent

Sincerely,<br>
The Swim School

<div style="padding: 1em 0em 0em 0em; font-size: x-small; color: #9BA2AB">If you are no longer interested in receiving emails from The Swim School, you can <a href="{{route('newsletter.unsubscribe', ['email' => $emailAddress])}}">unsubscribe</a>.</div>

@endcomponent
