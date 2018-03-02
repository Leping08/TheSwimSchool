@component('mail::message')
# {{$lesson->group->type}}

Don't forget about your swim lessons tomorrow {{$lesson->class_start_time->format('g:ia')}} - {{$lesson->class_end_time->format('g:ia')}}.

@component('mail::panel')
### What To Bring
* Bathing Suit
* Towel
* Sun Screen
* Pool Deck Shoes
@endcomponent

@component('mail::panel')
### Location
{{$lesson->location->street}}<br>
{{$lesson->location->city}}, {{$lesson->location->state}} {{$lesson->location->zip}}
@endcomponent

@component('mail::panel')
### Class Times

@foreach($lesson->DaysOfTheWeek as $day)
{{$day->day}}: {{$lesson->class_start_time->format('g:i a')}} - {{$lesson->class_end_time->format('g:i a')}}<br>
@endforeach
{{$lesson->class_start_date->format('F jS')}} - {{$lesson->class_end_date->format('F jS')}}

@endcomponent

Thanks,<br>
The Swim School
@endcomponent
