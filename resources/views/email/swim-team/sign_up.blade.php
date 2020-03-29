@component('mail::layout')

@slot('header')
@component('mail::header', ['url' => config('app.url')])
<img style="max-width: 350px;" src="{{asset('img/logos/north-river-rapids.png')}}">
@endcomponent
@endslot

<img style="margin-bottom: 2em;" src="{{asset('img/swim-team/dive-cropped.jpg')}}">

# Welcome to the North River Rapids Swim Team!

@component('mail::panel')
**{{$swimmer->firstName}} {{$swimmer->lastName}}**, thanks for signing up for the North River Rapids Swim Team {{$swimmer->level->name}} Level.
@endcomponent

@component('mail::panel')
### {{$swimmer->level->name}} Level Practice Schedule
@foreach($swimmer->level->schedule as $day)
{{$day->day}} {{\Carbon\Carbon::parse($day->pivot->start_time)->format('g:ia')}} - {{\Carbon\Carbon::parse($day->pivot->end_time)->format('g:ia')}}<br>
@endforeach
@endcomponent

@component('mail::panel')
### Season Length
{{$swimmer->season->dates}}
@endcomponent

@component('mail::panel')
### Practice Location
2250 Wilderness Blvd W,\
Parrish, FL 34219
@endcomponent

@component('mail::panel')
### What To Bring
* Bathing Suit
* Towel
* Goggles
@endcomponent

Thanks,<br>
North River Rapids

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
