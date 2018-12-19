@component('mail::message')


<img style="margin-bottom: 2em;" src="{{asset('img/hh.jpg')}}">



@component('mail::panel')
# What A Year!
We won the Gold Daisy Award for Best Swim Lessons in Manatee County and started the North River Swim Team this year. Thank you for making our 2018 a great one! We wish you and your family a joyous holiday season and a very happy New Year!
@endcomponent

Sincerely,<br>
The Swim School

<div style="padding: 1em 0em 0em 0em; font-size: x-small; color: #9BA2AB">If you are no longer interested in receiving emails from The Swim School, you can <a href="theswimschoolfl.com/unsubscribe/{{{$emailAddress}}}">unsubscribe</a>.</div>
@endcomponent
