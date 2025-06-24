@component('mail::message')
# Private Swim Lesson Reminder

<img style="margin-bottom: 2em;" src="{{asset('img/lessons/kids-floating.jpg')}}" alt="">

We are looking forward to seeing you at {{ $location->name }} for your private swim lesson tomorrow {{$pool_session->start->format('l F jS')}} from {{$pool_session->start->format('g:ia')}} - {{$pool_session->end->format('g:ia')}}.

@component('mail::panel')
### Time
Tomorrow {{$pool_session->start->format('l F jS')}}\
{{$pool_session->start->format('g:ia')}} - {{$pool_session->end->format('g:ia')}}
@endcomponent

@component('mail::panel')
### Place
{{$location->street}}\
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
* Goggles (except for parent toddlers)
@endcomponent

@if($location->pool_access_instructions)
@component('mail::panel')
### Pool Access Instructions
{{$location->pool_access_instructions}}
@endcomponent
@endif


{{--@component('mail::panel')--}}
{{--### Inclement Weather--}}
{{--In the event of inclement weather (i.e. thunder/lightning, heavy rain, and/or air temperature of 65 degrees or below), swim lesson classes will be cancelled. The instructor will contact you via text when a class needs to be cancelled due to inclement weather and will notify you as to when a makeup class will be scheduled. It is best to assume swim lesson classes are on as scheduled if you are not contacted by the instructor. Makeup classes will only be scheduled for swim lesson classes cancelled by the instructor.--}}
{{--@endcomponent--}}


Thanks,<br>
The Swim School
@endcomponent
