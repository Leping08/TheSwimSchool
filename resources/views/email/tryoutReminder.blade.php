@component('mail::message')
# North River Swim Team Tryouts

Don't forget about the North River Swim Team tryouts tomorrow.

@component('mail::panel')
### Time
{{$tryout->event_time->format('l F jS')}} {{$tryout->event_time->format('g:ia')}} - {{$tryout->event_time->addHour()->format('g:ia')}}
@endcomponent

@component('mail::panel')
### Place
{{$tryout->location->street}}<br>
{{$tryout->location->city}}, {{$tryout->location->state}} {{$tryout->location->zip}}<br>
<br>{{$tryout->location->pool_access_instructions}}
@endcomponent

@component('mail::panel')
### What To Bring
* Bathing Suit
* Towel
* Goggles
* Pool Deck Shoes
@endcomponent

Thanks,<br>
The Swim School
@endcomponent
