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
<br>When you arrive at the gate for entry into River Wilderness Country Club on the day of the tryout, please provide the gatehouse guard with your child's first and last name. Once you enter, the clubhouse and pool is approximately 3 miles through the residential neighborhood and will be on the right.
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
