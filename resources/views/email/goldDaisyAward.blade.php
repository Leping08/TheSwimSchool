@component('mail::message')
# Last Chance To Vote For The Swim School!

<div style="display:flex; justify-content: center; padding: 2em 0em;"><img src="{{asset('img/email/gold-daisy-award-logo.png')}}"></div>

It's your last chance to vote for The Swim School! Voting for the 2018 Gold Daisy Awards is almost over and The Swim School is in 2nd place by a few votes. We need your help!

If you haven't voted, please visit the link below and cast your vote for The Swim School before the August 5th deadline! Thank you for your support!!

@component('mail::button', ['url' => 'https://docs.google.com/forms/d/e/1FAIpQLSdGE6GcNpQTkQtLHvOcdbrrYUafkrqbTGA58z2ODRaXJay_og/viewform'])
    Cast Your Vote
@endcomponent

Thanks,<br>
The Swim School


<div style="padding: 1em 0em 0em 0em; font-size: x-small; color: #9BA2AB">If you are no longer interested in receiving emails from The Swim School, you can <a href="theswimschoolfl.com/unsubscribe/{{{$emailAddress}}}">unsubscribe</a>.</div>
@endcomponent
