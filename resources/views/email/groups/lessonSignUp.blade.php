@component('mail::message')
# {{$lesson->group->type}}

<img style="margin-bottom: 2em;" src="{{asset('img/lessons/kids-floating.jpg')}}" alt="">

Thanks for signing up for swim lessons through The Swim School.


@component('mail::panel')
### Time
Lessons run from {{$lesson->class_start_date->format('l F jS')}} - {{$lesson->class_end_date->format('l F jS')}}.
Lessons are on @foreach($lesson->DaysOfTheWeek as $day){{$day->day}}{{$loop->last ? '' : ', '}}@endforeach from {{$lesson->class_start_time->format('g:ia')}} - {{$lesson->class_end_time->format('g:ia')}}.
@endcomponent


@component('mail::panel')
### Place
{{$lesson->location->street}},\
{{$lesson->location->city}}, {{$lesson->location->state}} {{$lesson->location->zip}}
@endcomponent


@component('mail::panel')
### What To Bring
* Bathing Suit
* Towel
* No Swim Shirts/Rash Guards Please
@endcomponent


@if($lesson->location->pool_access_instructions)
@component('mail::panel')
### Pool Access Instructions
{{$lesson->location->pool_access_instructions}}
@endcomponent
@endif


Thanks,<br>
The Swim School
@endcomponent
