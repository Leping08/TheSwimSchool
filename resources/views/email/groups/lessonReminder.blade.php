@component('mail::message')

<img style="margin-bottom: 2em;" src="{{asset('img/thank-you/smile.jpg')}}" alt="">

This is a reminder for your upcoming {{$lesson->group->type}} swim lessons.
The first lesson is tomorrow {{$lesson->class_start_time->format('g:ia')}} - {{$lesson->class_end_time->format('g:ia')}}.

@component('mail::panel')
### What To Bring
* Bathing Suit
* Towel
* Sunscreen
@endcomponent


@component('mail::panel')
### Location
{{$lesson->location->street}}\
{{$lesson->location->city}}, {{$lesson->location->state}} {{$lesson->location->zip}}<br>
@endcomponent


@component('mail::panel')
### Class Times
@foreach($lesson->DaysOfTheWeek as $day)
{{$day->day}}: {{$lesson->class_start_time->format('g:i a')}} - {{$lesson->class_end_time->format('g:i a')}}\
@endforeach
{{$lesson->class_start_date->format('F jS')}} - {{$lesson->class_end_date->format('F jS')}}
@endcomponent


@if($lesson->location->pool_access_instructions)
@component('mail::panel')
### Pool Access Instructions
{{$lesson->location->pool_access_instructions}}
@endcomponent
@endif


@component('mail::panel')
### Inclement Weather
In the event of inclement weather (i.e. thunder/lightning, heavy rain, and/or air temperature of 65 degrees or below), swim lesson classes will be cancelled. The instructor will contact you via text when a class needs to be cancelled due to inclement weather and will notify you as to when a makeup class will be scheduled. It is best to assume swim lesson classes are on as scheduled if you are not contacted by the instructor. Makeup classes will only be scheduled for swim lesson classes cancelled by the instructor.
@endcomponent


Thanks,<br>
The Swim School
@endcomponent
