@component('mail::layout')

@slot('header')
@component('mail::header', ['url' => config('app.url')])
<img style="max-width: 350px;" src="{{asset('img/logos/north-river-rapids.png')}}">
@endcomponent
@endslot

<img style="margin-bottom: 2em;" src="{{asset('img/swim-team/dive-cropped.jpg')}}">

# Congratulations!

@component('mail::panel')
**{{$athlete->firstName}} {{$athlete->lastName}}**, you made the North River Rapids Swim Team!
Based on tryouts, we would like to place you in {{$athlete->level->name}} level.
@endcomponent

@component('mail::panel')
### Season Length
{{$athlete->season->dates}}
@endcomponent

@component('mail::panel')
### {{$athlete->level->name}} Level Practice Schedule
@foreach($athlete->level->schedule as $day)
{{$day->day}} {{\Carbon\Carbon::parse($day->pivot->start_time)->format('g:ia')}} - {{\Carbon\Carbon::parse($day->pivot->end_time)->format('g:ia')}}<br>
@endforeach
@endcomponent

@component('mail::panel')
### Practice Location
2250 Wilderness Blvd W,\
Parrish, FL 34219
@endcomponent

@if($promoCode)
@component('mail::panel')
### Promo Code
For {{$promoCode->discount_percent}}% off use code: {{$promoCode->code}}
@endcomponent
@endif

@component('mail::button', ['url' => config('app.url').'swim-team/level/'.$athlete->level->id.'/swimmer/'.$athlete->hash])
Sign Up
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
