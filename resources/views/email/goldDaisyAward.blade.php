@component('mail::message')
# The Swim School Wants Your Vote!

<div style="display:flex; justify-content: center; padding: 2em 0em;"><img src="{{asset('img/gold-daisy-award-logo.png')}}"></div>

We are very excited and honored to share that The Swim School has been nominated as Best Swim Lessons in Manatee County!  This is the 4th year in a row we've been nominated and this year we want to WIN! Please help us out by taking a moment to cast your vote in support of THE SWIM SCHOOL. Please click on the button below to cast your vote.

@component('mail::button', ['url' => 'https://docs.google.com/forms/d/e/1FAIpQLSdGE6GcNpQTkQtLHvOcdbrrYUafkrqbTGA58z2ODRaXJay_og/viewform'])
    Cast Your Vote
@endcomponent

Thanks,<br>
The Swim School


<div style="padding: 1em 0em 0em 0em; font-size: x-small; color: #9BA2AB">If you are no longer interested in receiving emails from The Swim School, you can <a href="theswimschoolfl.com/unsubscribe/{{{$emailAddress}}}">unsubscribe</a>.</div>
@endcomponent
