@component('mail::message')
# Private Swim Lessons

<img style="margin-bottom: 2em;" src="{{asset('img/lessons/kids-floating.jpg')}}" alt="">

Thanks for signing up for private swim lessons through The Swim School. Here is some info on the first lesson:

@component('mail::panel')
### Time
The first lesson is {{$first_pool_session->start->format('g:ia')}} - {{$first_pool_session->end->format('g:ia')}} on {{$first_pool_session->start->format('l F jS')}}.
@endcomponent

@component('mail::panel')
### Place
{{$location->street}},\
{{$location->city}}, {{$location->state}} {{$location->zip}}
@endcomponent

@component('mail::panel')
### Instructor
{{ $instructor->name }}\
<a href="tel:{{$instructor->phone}}">{{ $instructor->phone }}</a>
@endcomponent

@component('mail::panel')
### What To Bring
* Bathing Suit
* Towel
* Sun Screen
@endcomponent

@component('mail::panel')
### Lessons
@foreach($pool_sessions as $pool_session)
* {{$pool_session->start->format('g:ia')}} - {{$pool_session->end->format('g:ia')}} on {{$pool_session->start->format('l F jS')}}
@endforeach
@endcomponent

@if($location->pool_access_instructions)
@component('mail::panel')
### Pool Access Instructions
{{$location->pool_access_instructions}}
@endcomponent
@endif


@component('mail::panel')
### Inclement Weather
In the event of inclement weather (i.e. thunder/lightning, heavy rain, and/or air temperature of 65 degrees or below), swim lesson classes will be cancelled. The instructor will contact you via text when a class needs to be cancelled due to inclement weather and will notify you as to when a makeup class will be scheduled. It is best to assume swim lesson classes are on as scheduled if you are not contacted by the instructor. Makeup classes will only be scheduled for swim lesson classes cancelled by the instructor.
@endcomponent


Thanks,<br>
The Swim School
@endcomponent
