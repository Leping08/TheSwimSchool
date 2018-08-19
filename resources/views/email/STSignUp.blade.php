@component('mail::message')
# Welcome to the The North River Swim Team!


@component('mail::panel')
**{{$swimmer->firstName}} {{$swimmer->lastName}}**, thanks for signing up for The North River Swim Team {{$swimmer->level->name}} Level.
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
2250 Wilderness Blvd W, <br>
Parrish, FL 34219
@endcomponent

@component('mail::panel')
### What To Bring
* Bathing Suit
* Towel
* Goggles
@endcomponent

Thanks,<br>
The Swim School
@endcomponent
