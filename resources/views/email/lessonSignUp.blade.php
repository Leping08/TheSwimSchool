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
* Bathing Suit
* Towel
* Sun Screen
@endcomponent

@component('mail::panel')
### Inclement Weather
In the event of inclement weather (i.e. thunder/lightning, heavy rain, and/or air temperature of 65 degrees or below), swim lesson classes will be cancelled. The instructor will contact you via text when a class needs to be cancelled due to inclement weather and will notify you as to when a makeup class will be scheduled. It is best to assume swim lesson classes are on as scheduled if you are not contacted by the instructor. Makeup classes will only be scheduled for swim lesson classes cancelled by the instructor.
@endcomponent

Thanks,<br>
The Swim School
@endcomponent
