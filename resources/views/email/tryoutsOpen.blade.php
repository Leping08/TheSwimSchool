@component('mail::layout')

@slot('header')
@component('mail::header', ['url' => config('app.url')])
<img style="max-width: 350px;" src="{{asset('img/logos/north-river-rapids.png')}}">
@endcomponent
@endslot

# North River Rapids Tryouts

@component('mail::panel')
<img style="margin-bottom: 2em;" src="{{asset('img/thank-you/breast-stroke.jpg')}}">
## Come join our team!
Registration for the North River Rapids swim team tryouts is now open! There are three dates to choose from and there is no fee to try out for the team.
@endcomponent

@component('mail::button', ['url' => config('app.url').'swim-team/tryouts?utm_source=newsletter&utm_medium=email&utm_campaign=swim_team_tryouts'])
Sign Up
@endcomponent

Thanks,<br>
North River Rapids

<div style="padding: 1em 0em 0em 0em; font-size: x-small; color: #9BA2AB">If you are no longer interested in receiving emails from The Swim School, you can <a href="theswimschoolfl.com/unsubscribe/{{{$emailAddress}}}">unsubscribe</a>.</div>

@slot('footer')
@component('mail::footer')
<div>
<div style="padding-top:10px; text-align:center !important;">
<a href="tel:1-941-773-1424" target="blank"><img style="padding: 10px;" src="{{asset('img/icons/phone-24x24.png')}}"></a>
<a href="mailto:theswimschoolfl@gmail.com"><img style="padding: 10px;" src="{{asset('img/icons/email-24x24.png')}}"></a>
<a href="https://www.facebook.com/North-River-Rapids-Swim-Team-209249439805502/" target="blank"><img style="padding: 10px;" src="{{asset('img/icons/facebook-box-24x24.png')}}"></a>
</div>

<p>
&copy; {{ date('Y') }} The Swim School. All rights reserved.
</p>
</div>
@endcomponent
@endslot

@endcomponent