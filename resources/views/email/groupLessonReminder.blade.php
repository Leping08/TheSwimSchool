@component('mail::message')
This is a reminder for your upcoming {{$lesson->group->type}} swim lessons.
The first lesson is tomorrow {{$lesson->class_start_time->format('g:ia')}} - {{$lesson->class_end_time->format('g:ia')}}.

@component('mail::panel')
### What To Bring
* Bathing Suit
* Towel
* Sunscreen
* Pool Deck Shoes
@endcomponent

@component('mail::panel')
### Location
{{$lesson->location->street}}<br>
{{$lesson->location->city}}, {{$lesson->location->state}} {{$lesson->location->zip}}<br>
@endcomponent

@component('mail::panel')
### Pool Deck instructions
<!-- TODO: Make this dynamic -->
All swim lesson participants are asked to please access the pool using the side pool gate entrance located around the back of the clubhouse. Please be reminded facility use outside of swim instruction is for Harrison Ranch residents only.
@endcomponent

@component('mail::panel')
### Class Times

@foreach($lesson->DaysOfTheWeek as $day)
{{$day->day}}: {{$lesson->class_start_time->format('g:i a')}} - {{$lesson->class_end_time->format('g:i a')}}<br>
@endforeach
{{$lesson->class_start_date->format('F jS')}} - {{$lesson->class_end_date->format('F jS')}}
@endcomponent

@component('mail::panel')
### Weather
In the event of inclement weather (i.e. thunder/lightning, heavy rain, and/or air temperature of 65 degrees or below), swim lesson classes will be cancelled. The instructor will contact you via text when a class needs to be cancelled due to inclement weather and will notify you as to when a makeup class will be scheduled. It is best to assume swim lesson classes are on as scheduled if you are not contacted by the instructor. Makeup classes will only be scheduled for swim lesson classes cancelled by the instructor.
@endcomponent

Thanks,<br>
The Swim School
@endcomponent
