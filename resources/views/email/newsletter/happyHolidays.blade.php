@component('mail::message')


<img style="margin-bottom: 2em;" src="{{asset('img/events/parrish-christmass-tree-lighting.jpg')}}" alt="">


@component('mail::panel')
# Parrish Hometown Christmas Event!

🎅 Have you heard?!? Santa is coming to Parrish this Saturday 12/14 3-7 PM at CenterState Bank! 🎅

⛄ The Swim School is excited to be a sponsor of this year’s FREE “Hometown” Christmas event and will have a face painting table! ⛄

🎄 We are also participating in the decorating contest so make sure you check out our fun, festive themed Christmas tree! 🎄

We hope to see you there and wish you all a wonderful holiday season!
@endcomponent

Sincerely,<br>
The Swim School

<div style="padding: 1em 0em 0em 0em; font-size: x-small; color: #9BA2AB">If you are no longer interested in receiving emails from The Swim School, you can <a href="{{route('newsletter.unsubscribe', ['email' => $emailAddress])}}">unsubscribe</a>.</div>
@endcomponent
