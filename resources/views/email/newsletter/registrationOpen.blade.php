@component('mail::message')

<img alt="" style="margin-bottom: 2em;" src="{{asset('img/lessons/hat.jpg')}}">

@component('mail::panel')
# Registration is Now Open!
Our first spring sessions of the 2021 swim season are now open for registration including our small group classes, March private lessons and spring swim club. April private lessons will open on 3/25. If you have any questions regarding which level to sign your child up for, please don’t hesitate to contact us. See you at the pool soon!
@endcomponent

@component('mail::button', ['url' => route('groups.lessons.index').'?utm_source=newsletter&utm_medium=email&utm_campaign=summer_lesson_registration'])
Sign Up
@endcomponent

Sincerely,<br>
The Swim School

<div style="padding: 1em 0em 0em 0em; font-size: x-small; color: #9BA2AB">If you are no longer interested in receiving emails from The Swim School, you can <a href="{{route('newsletter.unsubscribe', ['email' => $emailAddress])}}">unsubscribe</a>.</div>
@endcomponent
