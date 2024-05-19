@component('mail::layout')

@slot('header')
@component('mail::header', ['url' => route('swim-team.index')])
<img style="max-width: 350px;" src="{{asset('img/logos/parrish-bull-sharks.png')}}" alt="">
@endcomponent
@endslot

# {{ config('swim-team.name') }} Tryouts

@component('mail::panel')
<img style="margin-bottom: 2em;" src="{{asset('img/swim-team/awards.jpg')}}" alt="">

## Calling all swimmers!
The {{ config('swim-team.name') }} Swim Team is now taking sign ups for tryouts for our upcoming 2021 summer swim team season! If you have a child who loves to swim and is interested in joining our team, sign up for one of our tryout spots today! All previous team members and current swim club participants are required to attend a tryout as well. We have three dates to choose from and there is no fee to tryout. The tryouts are held at River Wilderness Golf & Country Club. For more information and to sign up for a tryout, click on the link below!
@endcomponent

@component('mail::button', ['url' => route('swim-team.index').'?utm_source=newsletter&utm_medium=email&utm_campaign=swim_team_tryouts'])
Sign Up
@endcomponent

Thanks,<br>
{{ config('swim-team.name') }}

<div style="padding: 1em 0em 0em 0em; font-size: x-small; color: #9BA2AB">If you are no longer interested in receiving emails from The Swim School, you can <a href="{{route('newsletter.unsubscribe', ['email' => $emailAddress])}}">unsubscribe</a>.</div>

@slot('footer')
@component('mail::footer')

@include('email.components.swim-team.footer')

@endcomponent
@endslot

@endcomponent
