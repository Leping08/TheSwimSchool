@component('mail::message')
# Congratulations!

@component('mail::panel')
**{{$athlete->firstName}} {{$athlete->lastName}}**, you made the North River Swim Team!
Based on tryouts we would like to place you in {{$athlete->swimTeamLevel->name}} level.
@endcomponent

## {{$athlete->swimTeamLevel->name}} Level
@component('mail::panel')
### Practice Schedule
@foreach($athlete->swimTeamLevel->schedule as $day)
{{$day->day}} {{\Carbon\Carbon::parse($day->pivot->start_time)->format('g:ia')}} - {{\Carbon\Carbon::parse($day->pivot->end_time)->format('g:ia')}}<br>
@endforeach
@endcomponent

@component('mail::panel')
### Practice Location
2250 Wilderness Blvd W, <br>
Parrish, FL 34219
@endcomponent

@component('mail::button', ['url' => ''])
Sign Up
@endcomponent

Thanks,<br>
The Swim School
@endcomponent
