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

{{-- ## Season --}}
{{-- {{$athlete->season->dates}} --}}

## {{$athlete->level->name}} Level Practice Schedule
@foreach($athlete->level->schedule as $day)
{{$day->day}} {{\Carbon\Carbon::parse($day->pivot->start_time)->format('g:ia')}} - {{\Carbon\Carbon::parse($day->pivot->end_time)->format('g:ia')}}<br>
@endforeach

## Practice Location
{{ config('swim-team.address') }}

@if($promoCode)
## Promo Code
For {{$promoCode->discount_percent}}% off use code: {{$promoCode->code}}
@endif
@endcomponent

@component('mail::button', ['url' => route('swim-team.index').'/athlete/'.$athlete->hash])
Sign Up
@endcomponent

Thanks,<br>
{{ config('swim-team.name') }}

@slot('footer')
@component('mail::footer')

@include('email.components.swim-team.footer')

@endcomponent
@endslot

@endcomponent
