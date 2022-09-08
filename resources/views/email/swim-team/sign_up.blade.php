@component('mail::layout')

@slot('header')
@component('mail::header', ['url' => route('swim-team.index')])
<img style="max-width: 350px;" src="{{asset('img/logos/parrish-bull-sharks.png')}}">
@endcomponent
@endslot

# Welcome to the {{ config('swim-team.full-name') }}!

@component('mail::panel')
<img style="max-width: 100%;" src="{{asset('img/swim-team/dive-cropped.jpg')}}">
@endcomponent

@component('mail::panel')
**{{$swimmer->firstName}} {{$swimmer->lastName}}**, thanks for signing up for the {{ config('swim-team.full-name') }} {{$swimmer->level->name}} Level.

## {{$swimmer->level->name}} Level Practice Schedule
@foreach($swimmer->level->schedule as $day)
- {{$day->day}} {{\Carbon\Carbon::parse($day->pivot->start_time)->format('g:ia')}} - {{\Carbon\Carbon::parse($day->pivot->end_time)->format('g:ia')}}<br>
@endforeach

## What To Bring
- Bathing Suit
- Towel
- Goggles

## Practice Location
{{config('swim-team.address')}}

## Season
{{$swimmer->season->dates}}
@endcomponent

Thanks,<br>
{{ config('swim-team.name') }}

@slot('footer')
@component('mail::footer')
<div>
<div style="padding-top:10px; text-align:center !important;">
<a href="{{ config('contact.phone.link') }}" target="blank"><img style="padding: 10px;" src="{{asset('img/icons/phone-24x24.png')}}" alt=""></a>
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
