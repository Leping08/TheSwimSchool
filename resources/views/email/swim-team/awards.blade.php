@component('mail::layout')

@slot('header')
@component('mail::header', ['url' => config('app.url')])
<img alt="" style="max-width: 350px;" src="{{asset('img/logos/north-river-rapids.png')}}">
@endcomponent
@endslot

<img alt="" style="margin-bottom: 2em;" src="{{asset('img/swim-team/2018-class.jpg')}}">

# North River Swim Team Awards Luau Luncheon Info

@component('mail::panel')
Please follow the link below to the Awards Luau Luncheon RSVP form. Please complete pre-order no later than 8/18. We hope to see you there!!!
@endcomponent

@component('mail::button', ['url' => 'https://forms.gle/2UBVomRwaxpFDDAm9'])
    RSVP Here
@endcomponent

Thanks,<br>
North River Rapids

@slot('footer')
@component('mail::footer')
<div>
<div style="padding-top:10px; text-align:center !important;">
<a href="tel:1-941-773-1424" target="blank"><img alt="" style="padding: 10px;" src="{{asset('img/icons/phone-24x24.png')}}"></a>
<a href="mailto:theswimschoolfl@gmail.com"><img alt="" style="padding: 10px;" src="{{asset('img/icons/email-24x24.png')}}"></a>
<a href="https://www.facebook.com/North-River-Rapids-Swim-Team-209249439805502/" target="blank"><img alt="" style="padding: 10px;" src="{{asset('img/icons/facebook-box-24x24.png')}}"></a>
</div>

<p>
&copy; {{ date('Y') }} The Swim School. All rights reserved.
</p>
</div>
@endcomponent
@endslot

@endcomponent
