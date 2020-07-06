@component('mail::message')
# 2020 Summer Swim Team Update

@component('mail::panel')
<img style="margin-bottom: 2em;" src="{{asset('img/swim-team/awards.jpg')}}">

In response to the increase in coronavirus cases being seen throughout Manatee County, we have made the difficult decision to forgo the 2020 summer swim team season. In lieu of the swim team, we will continue offering our two week swim club sessions through August 6th with no more than 10 participants per group. There are a few spots left in our next Flying Fish and Shark swim club sessions starting this Monday, June 29th. You can register using the links below.
@endcomponent

@component('mail::button', ['url' => config('app.url') .'lessons?utm_source=newsletter&utm_medium=email&utm_campaign=swim_team_tryouts'])
Sign Up
@endcomponent

Thanks,<br>
The Swim School

<div style="padding: 1em 0em 0em 0em; font-size: x-small; color: #9BA2AB">If you are no longer interested in receiving emails from The Swim School, you can <a href="{{route('newsletter.unsubscribe', ['email' => $emailAddress])}}">unsubscribe</a>.</div>
@endcomponent
