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

@include('email.components.swim-team.footer')

@endcomponent
@endslot

@endcomponent
