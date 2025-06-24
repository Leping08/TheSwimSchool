@component('mail::message')
# Private Swim Lessons

<img style="margin-bottom: 2em;" src="{{asset('img/lessons/kids-floating.jpg')}}" alt="">

Thanks for signing up for private swim lessons through The Swim School. Here is some info on your lessons:

**Dates and Times:**

@foreach($stoted_pool_sessions as $pool_session)
@component('mail::panel')
Date: **{{$pool_session->start->format('l F jS')}}**<br>
Time: **{{$pool_session->start->format('g:ia')}} - {{$pool_session->end->format('g:ia')}}**<br>
Location: **{{$pool_session->location->name ?? ($pool_session->location->street ?? 'N/A')}}**<br>
Instructor: {{$pool_session->instructor->name ?? 'N/A'}} @if($pool_session->instructor && $pool_session->instructor->phone) (<a href="tel:{{$pool_session->instructor->phone}}">{{$pool_session->instructor->phone}}</a>) @endif
@endcomponent
@endforeach

**Location Details:**

@foreach($unique_locations as $loc)
@component('mail::panel')
## {{$loc->name}}
{{$loc->street}},\
{{$loc->city}}, {{$loc->state}} {{$loc->zip}}

@if($loc->pool_access_instructions)
**Pool Access Instructions:** {{$loc->pool_access_instructions}}
@endif
@endcomponent
@endforeach

**What To Bring**

@component('mail::panel')
* Bathing Suit
* Towel
* Goggles (except for parent toddlers)
@endcomponent

Thanks,<br>
The Swim School
@endcomponent
