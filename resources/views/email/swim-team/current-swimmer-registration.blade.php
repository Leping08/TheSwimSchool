@component('mail::layout')

@slot('header')
@component('mail::header', ['url' => route('swim-team.index')])
<img alt="" style="max-width: 300px;" src="{{asset('img/logos/parrish-bull-sharks.png')}}">
@endcomponent
@endslot

# YEAR ROUND SWIM TEAM REGISTRATION IS OPEN!!!

@component('mail::panel')
<img alt="" style="max-width: 100%;" src="{{asset('img/swim-team/backstroke.jpg')}}">
@endcomponent

@component('mail::panel')
Hey {{ $swimmer->firstName }},

It's official! The Parrish Bull Sharks swim team is going year round starting Monday, September 19th! Here are all the details for returning swimmers...

To secure your spot, there is a $50 Registration Fee per swimmer due by Friday, September 16th.

A recurring monthly fee will be applied on the 1st of each month (starting October 1st) per swimmer based on their assigned practice level within the program. A multiple child discount of 10% will be applied when applicable. The monthly fees are based on the current practice schedule frequency and duration.

- White Team 1
  - $125/month
  - Practices: M/W/F 5:00PM-5:45PM

- White Team 2
  - $125/month
  - Practices: M/W/F 5:00PM-5:45PM

- Gray Team 
  - $135/month
  - Practices: M/W/F 5:00PM-6:00PM

- Blue Team
  - $150/month
  - Practices: M/W/F 5:00PM-6:00PM

Swim meets will occur once per month during the school year (with the exception of January and August) and twice per month in June and July. The Parent Non-Volunteer Fee (optional) is being increased to $100 per swimmer to accommodate the increase in swim meets throughout a calendar year. This fee will now be due prior to each swimmer's participation in their first swim meet if you choose this option in lieu of volunteering.

We will take program breaks throughout the school year in accordance with Manatee County School District holidays, vacations, etc. We will also continue to take an annual break in August and will host our annual awards banquet at the end of August. Program fees will not be prorated for scheduled breaks, including the month of August. Program fees for the month of August will go towards the cost of the awards banquet.

Please contact me with any questions you may have by using either the Remind App, emailing info@theswimschoolfl.com or calling {{ config('contact.phone.number') }}! Let's Go Bull Sharks! Chomp, Chomp, Chomp!
@endcomponent

@component('mail::button', ['url' => route('swim-team.swimmer.register', ['swimmer' => $swimmer, 'level' => $swimmer->level])])
Year Round Swim Team Registration
@endcomponent

Thanks,<br>
{{ config('swim-team.name') }}

@slot('footer')
@component('mail::footer')
<div>
<div style="padding-top:10px; text-align:center !important;">
<a href="{{ config('contact.phone.link') }}" target="blank"><img alt="" style="padding: 10px;" src="{{asset('img/icons/phone-24x24.png')}}"></a>
<a href="{{ config('contact.email.link') }}"><img alt="" style="padding: 10px;" src="{{asset('img/icons/email-24x24.png')}}"></a>
<a href="https://www.facebook.com/North-River-Rapids-Swim-Team-209249439805502/" target="blank"><img alt="" style="padding: 10px;" src="{{asset('img/icons/facebook-box-24x24.png')}}"></a>
</div>

<p>
&copy; {{ date('Y') }} The Swim School. All rights reserved.
</p>
</div>
@endcomponent
@endslot

@endcomponent
