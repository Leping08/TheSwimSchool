@component('mail::layout')

@slot('header')
@component('mail::header', ['url' => route('swim-team.index')])
<img style="max-width: 350px;" src="{{asset('img/logos/parrish-bull-sharks.png')}}">
@endcomponent
@endslot

# {{ config('swim-team.name') }} Tryouts

Don't forget about the {{ config('swim-team.full-name') }} tryouts tomorrow.

@component('mail::panel')
### Time
{{$tryout->event_time->format('l F jS')}} {{$tryout->event_time->format('g:ia')}} - {{$tryout->event_time->addHour()->format('g:ia')}}
@endcomponent

@component('mail::panel')
### Place
{{$tryout->location->street}}\
{{$tryout->location->city}}, {{$tryout->location->state}} {{$tryout->location->zip}}\
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
{{ config('swim-team.name') }}

@slot('footer')
@component('mail::footer')
<div>
<div style="padding-top:10px; text-align:center !important;">
<a href="{{ config('contact.phone.link') }}" target="blank"><img style="padding: 10px;" src="{{asset('img/icons/phone-24x24.png')}}" alt=""></a>
<a href="{{ config('contact.email.link') }}"><img style="padding: 10px;" src="{{asset('img/icons/email-24x24.png')}}" alt=""></a>
<a href="https://www.facebook.com/North-River-Rapids-Swim-Team-209249439805502/" target="blank"><img style="padding: 10px;" src="{{asset('img/icons/facebook-box-24x24.png')}}" alt=""></a>
</div>

<p>
&copy; {{ date('Y') }} The Swim School. All rights reserved.
</p>
</div>
@endcomponent
@endslot

@endcomponent