@component('mail::message')
# {{$lesson->group->type}}

Thanks for signing up for swim lessons through The Swim School.

@component('mail::panel')
### Time
Lessons run from {{$lesson->class_start_date->format('l F jS')}} - {{$lesson->class_end_date->format('l F jS')}}.
Lessons are on @foreach($lesson->DaysOfTheWeek as $day){{$day->day}}{{$loop->last ? '' : ', '}}@endforeach from {{$lesson->class_start_time->format('g:ia')}} - {{$lesson->class_end_time->format('g:ia')}}.
@endcomponent

@component('mail::panel')
### Place
{{$lesson->location->street}},
{{$lesson->location->city}}, {{$lesson->location->state}} {{$lesson->location->zip}}
@endcomponent

@component('mail::panel')
### What To Bring
* Swimwear
* Towel
@endcomponent

Thanks,<br>
The Swim School
@endcomponent
