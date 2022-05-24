@component('mail::layout')

@slot('header')
@component('mail::header', ['url' => route('swim-team.index')])
<img style="max-width: 350px;" src="{{asset('img/logos/parrish-bull-sharks.png')}}" alt="">
@endcomponent
@endslot

@component('mail::panel')
<img style="margin-bottom: 2em;" src="{{asset('img/swim-team/2021-class.jpg')}}" alt="">

# Congratulations!

**{{$athlete->firstName}} {{$athlete->lastName}}**, you made the {{ config('swim-team.full-name') }}!
Based on tryouts, we would like to place you in {{$athlete->level->name}} level.

## Season
{{$athlete->season->dates}}

## {{$athlete->level->name}} Level Practice Schedule
@foreach($athlete->level->schedule as $day)
{{$day->day}} {{\Carbon\Carbon::parse($day->pivot->start_time)->format('g:ia')}} - {{\Carbon\Carbon::parse($day->pivot->end_time)->format('g:ia')}}<br>
@endforeach

## Practice Location
715 17th St East,\
Palmetto, FL 34221

@if($promoCode)
## Promo Code
For {{$promoCode->discount_percent}}% off use code: {{$promoCode->code}}
@endif
@endcomponent

@component('mail::button', ['url' => route('swim-team.index').'/level/'.$athlete->level->id.'/swimmer/'.$athlete->hash])
Sign Up
@endcomponent

Thanks,<br>
{{ config('swim-team.name') }}

@slot('footer')
@component('mail::footer')
<div>
<div style="padding-top:10px; text-align:center !important;">
<a href={{ config('contact.phone.link') }}" target="blank"><img style="padding: 10px;" src="{{asset('img/icons/phone-24x24.png')}}" alt=""></a>
<a href="{{ config('contact.email.link') }}"><img style="padding: 10px;" src="{{asset('img/icons/email-24x24.png')}}" alt=""></a>
<a href="https://www.facebook.com/North-River-Rapids-Swim-Team-209249439805502/" target="blank"><img style="padding: 10px;" src="{{asset('img/icons/facebook-box-24x24.png')}}" alt=""></a>
</div>

<p>
&copy; {{ date('Y') }} The Swim School. All rights reserved.
</p>
</div>
@endcomponent
@endslot

@endcomponent
